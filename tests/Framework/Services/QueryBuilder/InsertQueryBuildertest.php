<?php

namespace Test\Framework\Services\QueryBuilder;

use Framework\Services\QueryBuilder\InsertQueryBuilder;
use Exception;
use Framework\Services\QueryBuilder\QueryBuilder;
use PHPUnit\Framework\TestCase;

class InsertQueryBuildertest extends TestCase
{
    public function testEmptyInto(): void
    {
        $qb = new QueryBuilder();
        $this->expectException(Exception::class);
        $result = $qb->insert()->into('')->values([''])->build();
    }

    public function testTable(): void
    {
        $qb = new InsertQueryBuilder();
        $result = $qb->into('user')->build();

        $this->assertNotEquals('SELECT * FROM user', $result->query);
    }

    public function testEmptyValues(): void
    {
        $qb = new InsertQueryBuilder();
        $this->expectException(Exception::class);
        $result = $qb->from('user')->values([])->build();
    }

    public function testValues(): void
    {
        $qb = new InsertQueryBuilder();

        $result = $qb
            ->into('user')
            ->values([
                'email' => 'test@example.com',
                'first_name' => 'test',
                'last_name' => 'test',
                'password' => 'testtest!'

            ])
            ->build();

        $expectedSql = 'INSERT INTO user (email, first_name, last_name, password) VALUES (:val_0, :val_1, :val_2, :val_3);';

        $this->assertEquals($expectedSql, $result->query);

    }
}