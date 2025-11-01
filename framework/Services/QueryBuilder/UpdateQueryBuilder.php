<?php

namespace Framework\Services\QueryBuilder;

use Framework\Dtos\QueryDto;

final class UpdateQueryBuilder extends AbstractQueryBuilder
{
    private array $setValues = [];

    public function set(array $values): self
    {
        foreach ($values as $column => $value) {
            $this->setValues[] = sprintf("%s = '%s'", $column, addslashes((string)$value));
        }
        return $this;
    }

    public function build(): QueryDto
    {
        $sql = sprintf(
            'UPDATE %s SET %s',
            $this->tableName,
            implode(', ', $this->setValues)
        );

        if (!empty($this->conditions)) {
            $sql .= ' WHERE ' . implode(' AND ', $this->conditions);
        }

        //return ['sql' => $sql . ';', 'params' => $this->params];
        return new QueryDto($sql, $this->params);
    }
}