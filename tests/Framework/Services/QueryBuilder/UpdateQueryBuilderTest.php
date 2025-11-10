<?php

namespace Test\Framework\Services\QueryBuilder;

use Framework\Services\QueryBuilder\QueryBuilder;
use Framework\Services\QueryBuilder\UpdateQueryBuilder;
use PHPUnit\Framework\TestCase;

class UpdateQueryBuilderTest extends TestCase
{
    public function testSet(): void
    {
        $qb = new QueryBuilder();
        $result = $qb->update()->from('user')->set([
            'email' => 'test@test'
        ])->where([
            'email' => 'check@check'
        ])->build();
        $expected = "UPDATE user SET email = 'test@test' WHERE (email = :where_0);";
        $this->assertEquals($expected, $result->query);
    }
}