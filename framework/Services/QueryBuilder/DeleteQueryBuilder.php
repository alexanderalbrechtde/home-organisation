<?php

namespace Framework\Services\QueryBuilder;

final class DeleteQueryBuilder extends AbstractQueryBuilder
{

    public function build(): array
    {
        $sql = sprintf('DELETE FROM %s', $this->tableName);

        if (!empty($this->conditions)) {
            $sql .= ' WHERE ' . implode(' OR ', $this->conditions);
        }

        return ['sql' => $sql . ';', 'params' => $this->params];
    }
}