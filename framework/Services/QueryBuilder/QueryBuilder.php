<?php

namespace Framework\Services\QueryBuilder;

class QueryBuilder
{
    public function select(array $columns): SelectQueryBuilder
    {
        return new SelectQueryBuilder($columns);
    }

    public function update(): UpdateQueryBuilder
    {
        return new UpdateQueryBuilder();
    }

    public function delete(): DeleteQueryBuilder
    {
        return new DeleteQueryBuilder();
    }

    public function insert(array $columns): InsertQueryBuilder
    {
        return new InsertQueryBuilder($columns);
    }
}