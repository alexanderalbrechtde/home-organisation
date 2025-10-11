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

    public function where(array $conditions): self
    {
        $groupParts = [];
        foreach ($conditions as $key => $val) {
            $groupParts[] = sprintf("%s = '%s'", $key, addslashes((string)$val));
        }
        $this->conditions[] = '(' . implode(' AND ', $groupParts) . ')';
        return $this;
    }

    public function build(): string
    {
        $sql = "DELETE FROM {$this->tableName}";
        if ($this->conditions) {
            $sql .= " WHERE " . implode(" OR ", $this->conditions);
        }
        return $sql . ';';
    }
}