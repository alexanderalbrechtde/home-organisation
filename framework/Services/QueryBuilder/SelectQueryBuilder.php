<?php

namespace Framework\Services\QueryBuilder;

class SelectQueryBuilder
{
    private array $columns = [];
    private string $tableName;

    public function select(string ...$columns): self
    {
        $this->columns = $columns;
        return $this;
    }

    public function from(string $tableName): self
    {
        $this->tableName = $tableName;
        return $this;
    }

    public function where(string $column, string $operator, mixed $value): self
    {
        $this->conditions[] = sprintf("%s %s '%s'", $column, $operator, addslashes($value));
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $dir = strtoupper($direction);
        if ($dir !== 'ASC' && $dir !== 'DESC') {
            $dir = 'ASC';
        }
        $this->orderParts[] = $column . ' ' . $dir;
        return $this;
    }

    public function limit(int $limit): self
    {
        return $this;
    }

    public function build(): string
    {
    }
}