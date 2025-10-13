<?php

namespace Framework\Services\QueryBuilder;

class SelectQueryBuilder
{
    private array $columns = [];
    private string $tableName;
    private array $orderParts = [];
    private array $conditions = [];
    private ?int $limitVal = null;
    private array $params = [];


    public function select(string ...$columns): self
    {
        $this->columns = $columns;
        return $this;
    }

    public function from(string $tableName): self
    {
        $this->tableName = $tableName;
        return $this;
    }

    public function where(array $conditions): self
    {
        $groupParts = [];
        foreach ($conditions as $column => $value) {
            $placeholder = 'where_' . count($this->params);
            $groupParts[] = sprintf('%s = :%s', $column, $placeholder);
            $this->params[$placeholder] = $value;
        }
        $this->conditions[] = '(' . implode(' AND ', $groupParts) . ')';
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

    public function build(): array
    {
        $columnName = !empty($this->columns) ? implode(', ', $this->columns) : '*';
        $sql = 'SELECT ' . $columnName . ' FROM ' . $this->tableName;

        if (!empty($this->conditions)) {
            $sql .= ' WHERE ' . implode(' OR ', $this->conditions);
        }
        if (!empty($this->orderParts)) {
            $sql .= ' ORDER BY ' . implode(', ', $this->orderParts);
        }
        if ($this->limitVal !== null) {
            $sql .= ' LIMIT ' . $this->limitVal;
        }

        return ['sql' => $sql . ';', 'params' => $this->params];
    }
}