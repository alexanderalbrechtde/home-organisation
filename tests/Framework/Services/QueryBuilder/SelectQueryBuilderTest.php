<?php

namespace Test\Framework\Services\QueryBuilder;

use Exception;
use Framework\Services\QueryBuilder\SelectQueryBuilder;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class SelectQueryBuilderTest extends TestCase
{

    #[Test]
    public function testEmptySelectArray(): void
    {
        $qb = new SelectQueryBuilder();
        $result = $qb->select([])->from('user')->build();

        $this->assertInstanceOf(\Framework\Dtos\QueryDto::class, $result);
        $this->assertEquals('SELECT * FROM user', $result->query);
        $this->assertEmpty($result->parameters);
    }

    #[DataProvider('queryProvider')]
    public function testCompleteSelectQuery(string $newQuery): void
    {
        $qb = new SelectQueryBuilder();
        $result = $qb
            ->select(['*'])
            ->from('user')
            ->where([])
            ->orderBy('id', 'ASC')
            ->limit(10)
            ->build();

        //$this->assertInstanceOf(\Framework\Dtos\QueryDto::class, $result);
        $expectedSql = $newQuery;
        $this->assertNotEquals($expectedSql, $result->query);
    }

    public static function queryProvider(): array
    {
        return [
            ['SELECT user.id AS user_id, user.first_name AS user_first_name,user.last_name AS user_last_name, user.email AS user_email FROM user LIMIT 10'],
            ['SELECT user.id AS user_id, user.first_name AS user_first_name,user.last_name AS user_last_name, user.email AS user_email FROM user LIMIT 10'],
            ['SELECT user.id AS user_id, user.first_name AS user_first_name,user.last_name AS user_last_name, user.email AS user_email FROM user LIMIT 10'],
            ['SELECT user.id AS user_id, user.first_name AS user_first_name,user.last_name AS user_last_name, user.email AS user_email FROM user LIMIT 10'],
            ['SELECT user.id AS user_id, user.first_name AS user_first_name,user.last_name AS user_last_name, user.email AS user_email FROM user LIMIT 10']
        ];
    }

    #[DataProvider('limitProvider')]
    public function testMinusLimit(int $limit): void
    {
        $qb = new SelectQueryBuilder();
        $this->expectException(Exception::class);
        $result = $qb->select()->limit($limit)->build();
    }

    public static function limitProvider(): array
    {
        return [
            [-1],
            [0],
        ];
    }

    public function testOrderBy(): void
    {
        $qb = new SelectQueryBuilder();
        $this->expectException(Exception::class);
        $result = $qb->select()->orderBy('id', 'FOO')->build();
    }

    public function testSameJoinTable(): void
    {
        $qb = new SelectQueryBuilder();
        $this->expectException(Exception::class);
        $result = $qb->select()->join('user', 'user', 'user')->build();
    }

    public function testEmptyJoinQuerry(): void
    {
        $qb = new SelectQueryBuilder();
        $result = $qb->select()->join('user', 'user', '')->build();
        $this->assertEmpty($result->parameters);
    }
}