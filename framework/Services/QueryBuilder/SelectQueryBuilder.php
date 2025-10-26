<?php

namespace Framework\Services\QueryBuilder;

use Framework\Dtos\QueryDto;

final class SelectQueryBuilder extends AbstractQueryBuilder
{
    private array $columns = [];
    private array $orderParts = [];
    private ?int $limitVal = null;

    private array $join = [];

    public function select(string ...$columns): self
    {
        $this->columns = $columns;
        return $this;
    }

    //public function join(array $join): self
    //{
    //    $this->join = $join;
    //    return $this;
    //}

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
        $columnName = !empty($this->columns) ? implode(', ', $this->columns) : '*';
        $sql = 'SELECT ' . $columnName . ' FROM ' . $this->tableName;

        //if (!empty($this->join)) {
        //    $sql .= ' INNER JOIN ' . implode(', ', $this->join);
        //}

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