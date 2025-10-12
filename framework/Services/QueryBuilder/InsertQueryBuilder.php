<?php

namespace Framework\Services\QueryBuilder;

class InsertQueryBuilder
{
    private ?string $tableName = null;
    private array $columns = [];
    private array $values = [];

    public function into(string $tableName): self
    {
        $this->tableName = $tableName;
        return $this;
    }

    public function values(array $data): self
    {
        foreach ($data as $column => $value) {
            $this->columns[] = $column;
            $this->values[] = sprintf("'%s'", addslashes((string)$value));
        }
        return $this;
    }

    public function build(): string
    {
        if ($this->tableName === null) {
            throw new \LogicException("Table name not set for INSERT query.");
        }

        if (empty($this->columns) || empty($this->values)) {
            throw new \LogicException("No columns or values set for INSERT query.");
        }

        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s);",
            $this->tableName,
            implode(', ', $this->columns),
            implode(', ', $this->values)
        );

        return $sql;
    }

}