<?php

namespace Framework\Services\QueryBuilder;

use Framework\Dtos\QueryDto;

final class DeleteQueryBuilder extends AbstractQueryBuilder
{

    public function build(): QueryDto
    {
        $sql = sprintf('DELETE FROM %s', $this->tableName);

        if (!empty($this->conditions)) {
            $sql .= ' WHERE ' . implode(' OR ', $this->conditions);
        }

        //return ['sql' => $sql . ';', 'params' => $this->params];
        return new QueryDto($sql, $this->params);
    }
}