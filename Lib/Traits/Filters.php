<?php
namespace Chrisvanlier2005\Traits;
use Exception;

enum Order{
    case ASC;
    case DESC;
}

trait Filters
{

    public function where($column, $operator, $value){
        $this->query .= " WHERE {$column} {$operator} ?";
        $this->parameters[] = $value;
        return $this;
    }
    private function getOrderEnum($order){
        switch($order){
            case "DESC":
                return Order::DESC;
            default:
                return Order::ASC;
        }
    }

    private function getOrderString($order){
        switch($order){
            case Order::DESC:
                return "DESC";
            default:
                return "ASC";
        }
    }

    public function orderBy($column, $order = "ASC"){
        $order = $this->getOrderEnum($order);
        $this->query .= " ORDER BY `{$column}` {$this->getOrderString($order)}";
        return $this;
    }

    public function limit($limit){
        $this->query .= " LIMIT ?";
        $this->parameters[] = $limit;
        return $this;
    }

    public function offset($offset){
        $this->query .= " OFFSET ?";
        $this->parameters[] = $offset;
        return $this;
    }

    public function orWhere($column, $operator, $value){
        $this->query .= " OR {$column} {$operator} ?";
        $this->parameters[] = $value;
        return $this;
    }

    public function andWhere($column, $operator, $value){
        $this->query .= " AND {$column} {$operator} ?";
        $this->parameters[] = $value;
        return $this;
    }

    public function whereIn($column, array $values){
        // check if it's an associative array
        if (array_keys($values) !== range(0, count($values) - 1)) {
            throw new Exception("Array must be indexed");
        }

        $this->query .= " WHERE {$column} IN (";
        // ?
        $this->query .= implode(',', array_fill(0, count($values), '?'));
        $this->query .= ")";
        $this->parameters = array_merge($this->parameters, $values);
        return $this;
    }
}