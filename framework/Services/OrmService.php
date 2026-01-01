<?php

namespace Framework\Services;

use App\Entities\UserEntity;
use Framework\Attributes\OrmColumn;
use Framework\Attributes\OrmTable;
use Framework\Interfaces\EntityInterface;
use Framework\Services\QueryBuilder\QueryBuilder;
use PDO;
use PhpParser\Node\Expr\Instanceof_;

class OrmService
{
    public function __construct(
        private PDO           $pdo,
        private QueryBuilder  $queryBuilder,
        private LoggerService $loggerService
    )
    {
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

    public function getEntityData(string $entityClass, array &$visited = []): array
    {
        if (in_array($entityClass, $visited, true)) {
            return [];
        }
        $visited[] = $entityClass;

        $reflection = new \ReflectionClass($entityClass);
        $tableAttributes = $reflection->getAttributes(OrmTable::class);
        $tableName = null;
        if ($tableAttributes !== []) {
            $tableName = $tableAttributes[0]->newInstance()->tableName;
        }
        if (!$tableName) {
            $tableName = $this->getTableName($entityClass);
        }

        $parameters = $reflection->getConstructor()->getParameters();

        $columns = [];
        $aliases = [];
        $relations = [];

        foreach ($parameters as $parameter) {
            $paramName = $parameter->getName();
            $type = $parameter->getType();
            $parameterType = $type ? $type->getName() : null;
            $attributes = $parameter->getAttributes(\Framework\Attributes\OrmColumn::class)[0] ?? null;

            $columnName = $attributes ? $attributes->newInstance()->columnName : $paramName;

            if ($columnName !== $paramName) {
                $aliases[$columnName] = $paramName;
            }

            if ($parameterType && class_exists($parameterType) && (new \ReflectionClass($parameterType))->isSubclassOf(
                    EntityInterface::class
                )) {
                $relations[$tableName . '.' . $columnName] = [
                    'entityClass' => $parameterType,
                    'joinColumn' => $parameterType::getTable() . '.id',
                ];

                $relatedMeta = $this->getEntityData($parameterType, $visited);
                if (!isset($relatedEntities)) {
                    $relatedEntities = [];
                }
                $relatedEntities[] = $relatedMeta;
            } else {
                $columns[] = $tableName . '.' . $columnName;
            }
        }

        $entityData = [
            $entityClass => [
                'tableName' => $tableName,
                'columns' => $columns,
                'aliases' => $aliases,
                'relations' => $relations,
            ],
        ];

        if (!empty($relatedEntities)) {
            foreach ($relatedEntities as $relMeta) {
                if (is_array($relMeta)) {
                    $entityData = array_merge($entityData, $relMeta);
                }
            }
        }

        return $entityData;
    }

    /**
     * @param class-string<EntityInterface> $entityClass
     */
    public function findBy(
        array  $filters,
        string $entityClass,
        ?int   $limit = null,
        ?array $orderBy = null

    ): array
    {
        $allEntityData = $this->getEntityData($entityClass);
        $singleEntityData = $allEntityData[$entityClass];
        $useTable = $singleEntityData['tableName'];
        $reversAliases = array_flip($singleEntityData['aliases'] ?? []);

        $tableMap = [];
        foreach ($allEntityData as $data) {
            $tableName = $data['tableName'];
            $tableMap[$tableName] = [];
            foreach ($data['columns'] as $dataColumn) {
                $tableMap[$tableName][] = substr($dataColumn, strlen($tableName) + 1);
            }
        }

        $qb = $this->queryBuilder->select();

        $select = $qb
            ->select($tableMap)
            ->from($useTable);

        foreach ($singleEntityData['relations'] as $fkKey => $relation) {
            [$ownerTable, $fkColumn] = explode('.', $fkKey, 2);
            [$joinTable, $joinColumn] = explode('.', $relation['joinColumn'], 2);
            $select->join($joinTable, "$ownerTable.$fkColumn", "$joinTable.$joinColumn");
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

        if ($limit) {
            $select->limit($limit);
        }

        $result = $select->build();

        $this->loggerService->log($result->query);
        $stmt = $this->pdo->prepare($result->query);
        $stmt->execute($result->parameters);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $entities = [];

        foreach ($rows as $row) {
            $groups = [];
            foreach ($row as $key => $value) {
                foreach ($allEntityData as $class => $meta) {
                    $t = $meta['tableName'];
                    if (str_starts_with($key, $t . '_')) {
                        $groups[$t][substr($key, strlen($t) + 1)] = $value;
                        break;
                    }
                }
            }
            $entities[] = $this->hydrate($entityClass, $groups, $allEntityData);
        }
        return $entities;
    }

    private function hydrate(string $class, array $groups, array $allMeta): object
    {
        $meta = $allMeta[$class];
        $tableName = $meta['tableName'];
        $reversAliases = array_flip($meta['aliases'] ?? []);

        $reflection = new \ReflectionClass($class);
        $arguments = [];

        foreach ($reflection->getConstructor()->getParameters() as $parameter) {
            $type = $parameter->getType();
            $typeName = $type ? $type->getName() : null;


            if ($typeName && class_exists($typeName) && is_subclass_of($typeName, EntityInterface::class)) {
                $arguments[] = $this->hydrate($typeName, $groups, $allMeta);
            } else {

                $col = $reversAliases[$parameter->getName()] ?? $parameter->getName();
                $val = $groups[$tableName][$col] ?? null;

                $arguments[] = ($val === null && $type && !$type->allowsNull()) ? '' : $val;
            }
        }

        return new $class(...$arguments);
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
    public function findOneBy(
        array  $filter,
        string $entityClass
    ): ?object
    {
        return $this->findBy($filter, $entityClass, 1)[0] ?? null;
    }

    public function delete(
        EntityInterface|array $entity
    ): bool
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


    public function save(
        EntityInterface $entity
    ): bool
    {
        if ($entity->id <= 0) {
            //dd(true);
            return $this->create($entity);
        }
        return $this->update($entity);
    }

    private function update(
        EntityInterface $entity
    ): bool
    {
        $data = get_object_vars($entity);
        $tableName = $entity::getTable();

        $meta = $this->getEntityData($entity::class);
        $aliases = $meta[$entity::class]['aliases'] ?? [];
        $propToColumn = array_flip($aliases);

        $mapped = [];
        foreach ($data as $property => $value) {
            if ($property === 'id') {
                continue;
            }
            $column = $propToColumn[$property] ?? $property;
            $mapped[$column] = $value;
        }

        $result = $this->queryBuilder
            ->update()
            ->from($tableName)
            ->set($mapped)
            ->where(['id' => (string)$entity->id])
            ->build();
        //dd($result);
        $this->loggerService->log($result->query);
        $stmt = $this->pdo->prepare($result->query);
        return $stmt->execute($result->parameters);
    }

    private function create(
        EntityInterface $entity
    ): bool
    {
        $data = get_object_vars($entity);
        $tableName = $entity::getTable();

        $meta = $this->getEntityData($entity::class);
        $aliases = $meta[$entity::class]['aliases'] ?? [];
        $propToColumn = array_flip($aliases);

        $mapped = [];
        foreach ($data as $property => $value) {
            if ($property === 'id') {
                continue;
            }
            $column = $propToColumn[$property] ?? $property;

            if ($value instanceof EntityInterface) {
                $mapped[$column] = $value->id ?? null;
            } else {
                $mapped[$column] = $value;
            }
        }

        $result = $this->queryBuilder
            ->insert()
            ->into($tableName)
            ->values($mapped)
            ->build();


        $this->loggerService->log($result->query);
        $stmt = $this->pdo->prepare($result->query);
        $ok = $stmt->execute($result->parameters);

        if ($ok && method_exists($entity, 'setId')) {
            $entity->setId((int)$this->pdo->lastInsertId());
        }
        return $ok;
    }
}