<?php

namespace Framework\Services;

use App\Entities\UserEntity;
use Framework\Interfaces\EntityInterface;
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

        $qb = $this->queryBuilder->select();

        $select = $qb
            ->select()
            ->from($table);

        if (array_is_list($filters)) {
            foreach ($filters as $filter) {
                $select->where($filter);
            }
        } else {
            $select->where($filters);
        }

        if (!empty($orderBy)) {
            foreach ($orderBy as $column => $direction) {
                $select->orderBy($column, $direction);
            }
        }
        if ($limit !== null && $limit > 0) {
            $select->limit($limit);
        }
        $sql = $select->build();
        //dd($sql);


        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
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
        if (is_Array($entity)) {
            $ok = true;
            foreach ($entity as $item) {
                if ($item instanceof EntityInterface) {
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


    public function save(EntityInterface $entity): bool
    {
        if ($entity->getId() == 0) {
            return $this->create($entity);
        }
        return $this->update($entity);
    }

    public function update(EntityInterface $entity): bool
    {
        // alle Daten; Ausgabe als Array
        $data = get_object_vars($entity);
        $tableName = $entity::getTable();
        //id wird nicht geupdated (Counter)
        if (array_key_exists('id', $data)) {
            unset($data['id']);
        }
        $sql = $this->queryBuilder
            ->update()
            ->from($tableName)
            ->set($data)
            ->where(['id' => (string)$entity->getId()])
            ->build();
        //dd($sql);
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute();
    }

    public function create(EntityInterface $entity): bool
    {
        $data = get_object_vars($entity);
        $tableName = $entity::getTable();

        if (array_key_exists('id', $data)) {
            unset($data['id']);
        }
        $sql = $this->queryBuilder
            ->insert()
            ->into($tableName)
            ->values($data)
            ->build();
        //dd($sql);
        $stmt = $this->pdo->prepare($sql);
        $ok = $stmt->execute();

        if ($ok && method_exists($entity, 'setId')) {
            $entity->setId((int)$this->pdo->lastInsertId());
        }
        return $ok;
    }
}