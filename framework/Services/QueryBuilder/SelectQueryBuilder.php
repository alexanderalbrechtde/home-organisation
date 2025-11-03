<?php

namespace Framework\Services\QueryBuilder;

use Exception;
use Framework\Dtos\QueryDto;

use function PHPUnit\Framework\throwException;

final class SelectQueryBuilder extends AbstractQueryBuilder
{
    private array $columns = [];
    private array $orderParts = [];
    private ?int $limitVal = null;

    private array $join = [];

    public function select(array ...$columns): self
    {
        $this->columns = $columns;
        return $this;
    }

    public function join(string $table, string $left, string $right): self
    {
        if($left == $right){
            throw new Exception("Join-Table are the same");
        }
        $this->join[] = "INNER JOIN $table ON $left = $right";
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $dir = strtoupper($direction);
        if ($dir !== 'ASC' && $dir !== 'DESC') {
            throw new Exception("Not valid order direction");
        }
        $this->orderParts[] = $column . ' ' . $dir;
        return $this;
    }

    public function limit(?int $limit): self
    {
        if ($limit <= 0 && $limit !== null) {
            throw new Exception("Not valid limit");
        }
        $this->limitVal = $limit;
        return $this;
    }

    public function build(): QueryDto
    {
        $columnList = [];

        foreach ($this->columns as $tableGroup) {
            foreach ($tableGroup as $table => $columns) {
                foreach ($columns as $column) {
                    $aliase = $table . '_' . $column;
                    $columnList[] = "$table.$column AS $aliase";
                }
            }
        }

        $columnName = !empty($columnList) ? implode(', ', $columnList) : '*';
        //dd($columnName);
        $sql = 'SELECT ' . $columnName . ' FROM ' . $this->tableName;

        if (!empty($this->join)) {
            $sql .= ' ' . implode(' ', $this->join);
        }
        if (!empty($this->conditions)) {
            $sql .= ' WHERE ' . implode(' OR ', $this->conditions);
        }
        if (!empty($this->orderParts)) {
            $sql .= ' ORDER BY ' . implode(', ', $this->orderParts);
        }
        if ($this->limitVal !== null) {
            $sql .= ' LIMIT ' . $this->limitVal;
        }
        //dd($sql);
        return new QueryDto($sql, $this->params);
    }
}