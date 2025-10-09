<?php

namespace Framework\Services\QueryBuilder;

class DeleteQueryBuilder
{
    private string $tableName;
    private array $conditions = [];


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

    public function build(): string
    {
        $sql = "DELETE FROM {$this->tableName}";
        if ($this->conditions) {
            $sql .= " WHERE " . implode(" AND ", $this->conditions);
        }
        return $sql . ';';
    }
}