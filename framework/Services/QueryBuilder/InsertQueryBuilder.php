<?php

namespace Framework\Services\QueryBuilder;

use Framework\Dtos\QueryDto;

final class InsertQueryBuilder
{
    private array $columns = [];
    private array $placeholders = [];

    public function into(string $tableName): self
    {
        $this->tableName = $tableName;
        return $this;
    }

    public function values(array $data): self
    {
        foreach ($data as $column => $value) {
            $placeholder = 'val_' . count($this->params);
            $this->columns[] = $column;
            $this->placeholders[] = ':' . $placeholder;
            $this->params[$placeholder] = $value;
        }
        return $this;
    }

    public function build(): QueryDto
    {
        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s);',
            $this->tableName,
            implode(', ', $this->columns),
            implode(', ', $this->placeholders)
        );

        //return ['sql' => $sql, 'params' => $this->params];
        return new QueryDto($sql, $this->params);
    }

}