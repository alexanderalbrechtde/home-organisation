<?php

namespace Test\Framework\Services\QueryBuilder;

use Framework\Services\QueryBuilder\DeleteQueryBuilder;
use PHPUnit\Framework\TestCase;

class DeleteQueryBuilderTest extends TestCase
{
    public function testQuery(): void
    {
        $qb = new DeleteQueryBuilder();
        $result = $qb->from('user')->where([])->build();
        $expected = 'DELETE FROM '. 'user';

        $this->assertNotEquals($expected, $result->query);
    }
}