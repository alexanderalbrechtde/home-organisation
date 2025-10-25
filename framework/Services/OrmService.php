<?php

namespace Framework\Services;

use App\Entities\UserEntity;
use Framework\Interfaces\EntityInterface;
use Framework\Services\QueryBuilder\QueryBuilder;
use PDO;

class OrmService
{
    public function __construct(private PDO $pdo, private QueryBuilder $queryBuilder, private LoggerService $loggerService)
    {
    }

    /**
     * @param class-string<EntityInterface> $entityClass
     */
    function findById(int $id, string $entityClass): ?object
    {
        return $this->findBy(['id' => $id], $entityClass, 1)[0] ?? null;
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
        ?array $join = null
    ): array {
        $table = $entityClass::getTable();

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
        $result = $select->build();
        //dd($result);

        $this->loggerService->log($result->query);
        $stmt = $this->pdo->prepare($result->query);
        $stmt->execute($result->parameters);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $reflection = new \ReflectionClass($entityClass);
        $constructor = $reflection->getConstructor();

        $entityParams = [];
        $enteties = [];
        if ($constructor) {
            foreach ($constructor->getParameters() as $parameter) {
                $type = $parameter->getType();
                if ($type instanceof \ReflectionNamedType) {
                    $typeName = $type->getName();
                    if (class_exists($typeName) && (new \ReflectionClass($typeName))->isSubclassOf(
                            EntityInterface::class
                        )) {

                        //gibt die Userentity der RoomEntity zurück
                        //$enteties[] = $parameter;
                        //dd($enteties);

                        $entityParams[] = [
                            'name' => $parameter->getName(),
                            'type' => $typeName,
                        ];
                    }
                }
            }
        }

        $entities = [];

        foreach ($rows as $row) {
            //dd($row);
            foreach ($entityParams as $ep) {
                $name = $ep['name'];
                $type = $ep['type'];
                //dd($name);

                //$row[$name] = $this->findById((int)$row[$name . '_id'], $type);
                //dd($row[$name]);

                $tableNames = $name;
                $id = [$row[$name .'_id']];
                //dd($id);

                $qa = $this->queryBuilder->select();
                $select = $qa
                    ->from($tableNames)
                    ->where([$name . '_id' =>$id]);
                $result = $select->build();
                dd($result);



                //unset($row[$name . '_id']);
            }
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