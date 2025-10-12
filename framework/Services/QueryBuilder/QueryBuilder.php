<?php

namespace Framework\Services\QueryBuilder;

class QueryBuilder
{
    public function select(): SelectQueryBuilder
    {
        return new SelectQueryBuilder();
    }

    public function update(): UpdateQueryBuilder
    {
        return new UpdateQueryBuilder();
    }

    public function delete(): DeleteQueryBuilder
    {
        return new DeleteQueryBuilder();
    }

    public function insert(): InsertQueryBuilder
    {
        return new InsertQueryBuilder();
    }
}