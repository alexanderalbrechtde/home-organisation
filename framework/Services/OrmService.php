<?php

namespace Framework\Services;

use App\Entities\UserEntity;
use Framework\Interfaces\EntityInterface;
use Framework\Services\QueryBuilder\QueryBuilder;
use PDO;

class OrmService
{
    public function __construct(
        private PDO $pdo,
        private QueryBuilder $queryBuilder,
        private LoggerService $loggerService
    ) {
    }

    /**
     * @param class-string<EntityInterface> $entityClass
     */
    function findById(int $id, string $entityClass): ?object
    {
        $table = $this->getTableName($entityClass);

        $select = $this->queryBuilder
            ->select()
            ->from($table)
            ->where([$table . '_id' => $id]);
        $result = $select->build();

        $this->loggerService->log($result->query);
        $stmt = $this->pdo->prepare($result->query);
        $stmt->execute($result->parameters);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new $entityClass(...$row);
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
        ?array $orderBy = null,

    ): array {
        $table = $this->getTableName($entityClass);
        $tableMap = $this->getEntityParams($entityClass);

        $entityParams = [];
        $reference = new \ReflectionClass($entityClass);
        $constructor = $reference->getConstructor();
        if ($constructor) {
            foreach ($constructor->getParameters() as $parameter) {
                dd($constructor->getParameters());
                $attributes = $parameter->getAttributes();
                foreach ($attributes as $attribute) {
                    $attrName = $attribute->getName();
                    if ($attrName === \Framework\Attributes\OrmColumn::class) {
                        $instance = $attribute->newInstance();
                    }
                }
                $types = $parameter->getType();
                if ($types instanceof \ReflectionNamedType) {
                    $t = $types->getName();
                    if (class_exists($t) && (new \ReflectionClass($t))->isSubclassOf(EntityInterface::class)) {
                        $entityParams[] = [
                            'name' => $parameter->getName(),
                            'type' => $t,
                        ];
                    }
                }
            }
        }

        $qb = $this->queryBuilder->select();

        $select = $qb
            ->select($tableMap)
            ->from($table);

        //$return = $this->getEntityParams($entityClass);
        //dd($return);

        foreach ($tableMap as $joinTable => $columns) {
            if ($joinTable === $table) {
                continue;
            }
            $select->join($joinTable, "$table.{$joinTable}_id", "$joinTable.{$joinTable}_id");
        }

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

        $result = $select->build();
        //dd($result);

        $this->loggerService->log($result->query);
        //hier krachts...
        //todo: OrmColumns an Datenbank anpassen
        $stmt = $this->pdo->prepare($result->query);
        //dd($stmt);
        $stmt->execute($result->parameters);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $entities = [];

        foreach ($rows as $row) {
            $groupes = [];

            foreach ($row as $key => $value) {
                [$prefix, $suffix] = explode('_', $key, 2);
                $groupes[$prefix][$suffix] = $value;
            }
            //dd($groupes);

            foreach ($entityParams as $ep) {
                $name = $ep['name'];
                $type = $ep['type'];

                $relatedTable = $type::getTable();

                //dd($table, $relatedTable);

                unset($groupes[$table][$relatedTable . '_id']);

                $relatedPayload = $groupes[$relatedTable];
                $groupes[$table][$name] = new $type(...$relatedPayload);
            }

            $entities[] = new $entityClass(...($groupes[$table]));
            //dd($groupes[$table]);
        }
        return $entities;
    }

    private function getTableName(string $entityClass)
    {
        $reflection = new \ReflectionClass($entityClass);
        $attributes = $reflection->getAttributes(\Framework\Attributes\OrmTable::class);

        $instance = $attributes[0]->newInstance();
        return $instance->tableName;
    }

    /**
     * @param class-string<EntityInterface> $entityClass
     */
    public function getEntityParams(string $entityClass): array
    {
        $reflection = new \ReflectionClass($entityClass);
        $properties = $reflection->getProperties();
        $constructor = $reflection->getConstructor();

        $table = $entityClass::getTable();
        $columns = [];

        foreach ($properties as $property) {
            $columns[] = $property->getName();
        }

        $tableMap = [
            $table => $columns
        ];
        //dd($tableMap);

        $entityParams = [];

        if ($constructor) {
            foreach ($constructor->getParameters() as $parameter) {
                $type = $parameter->getType();
                if ($type instanceof \ReflectionNamedType) {
                    $typeName = $type->getName();
                    if (class_exists($typeName) && (new \ReflectionClass($typeName))->isSubclassOf(
                            EntityInterface::class
                        )) {
                        $entity = $this->getEntityParams($typeName);
                        $tableMap = array_merge($tableMap, $entity);
                        $entityParams[] = [
                            'name' => $parameter->getName(),
                            'type' => $typeName,
                        ];
                    }
                }
            }
        }

        return $tableMap;
    }

    /**
     * @param class-string<EntityInterface> $entityClass
     */
    public function findOneBy(array $filter, string $entityClass, ?array $orderBy = null): ?object
    {
        return $this->findBy($filter, $entityClass, 1)[0] ?? null;
    }

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

        $id = $entity->id;
        if ($id === null) {
            return false;
        }
        $result = $this->queryBuilder
            ->delete()
            ->from($tableName)
            ->where(['id' => (string)$id])
            ->build();
        //dd($result);

        $stmt = $this->pdo->prepare($result['sql']);
        return $stmt->execute($result['params']);
    }


    public function save(EntityInterface $entity): bool
    {
        if ($entity->id <= 0) {
            return $this->create($entity);
        }
        return $this->update($entity);
    }

    private function update(EntityInterface $entity): bool
    {
        $data = get_object_vars($entity);
        $tableName = $entity::getTable();
        if (array_key_exists('id', $data)) {
            unset($data['id']);
        }
        $result = $this->queryBuilder
            ->update()
            ->from($tableName)
            ->set($data)
            ->where(['id' => (string)$entity->id])
            ->build();
        //dd($result);
        $stmt = $this->pdo->prepare($result['sql']);

        return $stmt->execute($result['params']);
    }

    private function create(EntityInterface $entity): bool
    {
        $data = get_object_vars($entity);
        $tableName = $entity::getTable();

        if (array_key_exists('id', $data)) {
            unset($data['id']);
        }
        $result = $this->queryBuilder
            ->insert()
            ->into($tableName)
            ->values($data)
            ->build();
        //dd($result);
        $stmt = $this->pdo->prepare($result['sql']);
        $ok = $stmt->execute($result['params']);


        if ($ok && method_exists($entity, 'setId')) {
            $entity->setId((int)$this->pdo->lastInsertId());
        }
        return $ok;
    }
}