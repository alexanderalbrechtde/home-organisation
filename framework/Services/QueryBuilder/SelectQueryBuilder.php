<?php

namespace Framework\Services\QueryBuilder;

use Framework\Dtos\QueryDto;

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
        $this->join[] = "INNER JOIN $table ON $left = $right";
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $dir = strtoupper($direction);
        if ($dir !== 'ASC' && $dir !== 'DESC') {
            $dir = 'ASC';
        }
        $this->orderParts[] = $column . ' ' . $dir;
        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limitVal = max(0, $limit);
        return $this;
    }

    public function build(): QueryDto
    {
        //dd($this->columns);
        //foreach($this->columns as $column){
        //    dd($column);
        //}
        $columnList = [];

        foreach ($this->columns as $tableGroup) {
            foreach ($tableGroup as $table => $columns) {
                foreach ($columns as $column) {
                    $aliase = $table . '_' . $column;
                    $columnList[] = "$table.$column AS $aliase";
                }
            }
        }
        //dd($columnList);

        $columnName = !empty($columnList) ? implode(', ', $columnList) : '*';
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
        return new QueryDto($sql, $this->params);
    }
}