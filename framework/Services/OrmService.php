<?php

namespace Framework\Services;

use App\Entities\UserEntity;
use Framework\Interfaces\EntityInterface;
use Framework\Services\QueryBuilder\DeleteQueryBuilder;
use Framework\Services\QueryBuilder\QueryBuilder;
use PDO;

class OrmService
{
    public function __construct(private PDO $pdo, private QueryBuilder $queryBuilder)
    {
    }

    /**
     * @param class-string<EntityInterface> $entityClass
     */
    function findById(int $id, string $entityClass): ?object
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $entityClass::getTable() . ' WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new $entityClass(...$row) : null;
    }

    /**
     * @param class-string<EntityInterface> $entityClass
     */
    public function findAll(string $entityClass, ?array $orderBy = null): array
    {
        return $this->findBy([], $entityClass);
    }

    /**
     * @param class-string<EntityInterface> $entityClass
     */
    public function findBy(
        array $filters,
        string $entityClass,
        ?int $limit = null,
        ?array $orderBy = null
    ): array {
        $table = $entityClass::getTable();
        $where = [];
        $parameters = [];

        if (array_is_list($filters)) {
            $groupIndex = 0;
            foreach ($filters as $filter) {
                $groupParts = [];
                foreach ($filter as $key => $val) {
                    $paramKey = $key . '_' . $groupIndex;
                    $groupParts[] = "$key = :$paramKey";
                    $parameters[$paramKey] = $val;
                }
                if (!empty($groupParts)) {
                    $where[] = '(' . implode(' AND ', $groupParts) . ')';
                }
                $groupIndex++;
            }
        } else {
            foreach ($filters as $key => $val) {
                $paramKey = $key . '_0';
                $where[] = "$key = :$paramKey";
                $parameters[$paramKey] = $val;
            }
        }

        $sql = 'SELECT * FROM ' . $table;

        if (!empty($where)) {
            $sql .= ' WHERE ' . implode(' OR ', $where);
        }


        if (!empty($orderBy)) {
            $orderParts = [];
            foreach ($orderBy as $key => $val) {
                $dir = strtoupper((string)$val) === 'ASC' ? 'ASC' : 'DESC';
                $orderParts[] = "$key $dir";
            }
            $sql .= ' ORDER BY ' . implode(', ', $orderParts);
        }


        if ($limit !== null && $limit > 0) {
            $sql .= ' LIMIT ' . (int)$limit;
        }


        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($parameters);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $entities = [];
        foreach ($rows as $row) {
            $entities[] = new $entityClass(...$row);
        }
        return $entities;
    }

    /**
     * @param class-string<EntityInterface> $entityClass
     */
    public function findOneBy(array $filter, string $entityClass, ?array $orderBy = null): ?object
    {
        return $this->findBy($filter, $entityClass, 1)[0] ?? null;
    }

    //sollte funktionieren; noch nicht getestet
    public function delete(EntityInterface|array $entity): bool
    {
        if(is_Array($entity)){
            $ok = true;
            foreach($entity as $item){
                if($item instanceof EntityInterface){
                    $ok = $this->delete($item) && $ok;
                }
            }
            return $ok;
        }

        $tableName = $entity::getTable();

        $id = $entity->getId();
        if ($id === null) {
            return false;
        }
        $sql = $this->queryBuilder
            ->delete()
            ->from($tableName)
            ->where(['id' => (string)$id])
            ->build();

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute();
    }


    private function save(EntityInterface $entity): bool
    {
        if ($entity->getId() == 0) {
            return $this->create($entity);
        }
        return $this->update($entity);
    }

    private function update(EntityInterface $entity): bool
    {
        // alle Daten; Ausgabe als Array
        $data = get_object_vars($entity);
        $tableName = $entity::getTable();
        //id wird nicht geupdated (Counter)
        if (array_key_exists('id', $data)) {
            unset($data['id']);
        }
        // dynamisches Erstellen der Query
        $assignments = [];
        foreach (array_keys($data) as $col) {
            $assignments[] = $col . ' = :' . $col;
        }
        $sql = 'UPDATE ' . $tableName . ' SET ' . implode(', ', $assignments) . ' WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $params = $data;
        $params['id'] = $entity->getId();
        //Ausführung
        return $stmt->execute($params);
    }

    private function create(EntityInterface $entity): bool
    {
        $data = get_object_vars($entity);
        if (array_key_exists('id', $data)) {
            unset($data['id']);
        }
        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $entity::getTable(),
            implode(',', array_keys($data)),
            ':' . implode(',:', array_keys($data))
        );

        $stmt = $this->pdo->prepare($sql);
        $ok = $stmt->execute($data);
        if (!$ok) {
            return false;
        }

        if (method_exists($entity, 'setId')) {
            $entity->setId((int)$this->pdo->lastInsertId());
        }
        return true;
    }
}