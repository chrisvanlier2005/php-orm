<?php

use Chrisvanlier2005\DatabaseQuery;
use Chrisvanlier2005\QueryType;
class HasMany extends Chrisvanlier2005\BaseRelation
{

    public function execute_relation(&$result, QueryType $type, $relation_primary_key = "id"){


        if ($type == QueryType::SINGLE)
        {
            return $this->fetchSingle($result);
        }
        return $this->fetchMultiple($result, $relation_primary_key);
    }

    public function fetchMultiple(&$results, $relation_primary_key)
    {
        $parentIds = [];
        $query = "SELECT * FROM {$this->table} WHERE {$this->foreignKeyName} IN (";
        foreach ($results as $result)
        {
            $parentIds[] = $result->$relation_primary_key;
        }
        $query .= implode(',', $parentIds);
        $query .= ")";
        $db = DatabaseQuery::new();
        $db->setQuery($query);
        $manyResults = $db->execute();

        foreach ($results as $result)
        {
            $result->{$this->table} = [];
            foreach($manyResults as $manyResult)
            {
                if ($manyResult->{$this->foreignKeyName} == $result->id)
                {
                    $result->{$this->table}[] = $manyResult;
                }
            }
        }
    }

    public function fetchSingle(&$result){
       $query = "SELECT * FROM {$this->table} WHERE {$this->foreignKeyName} = ?";
       $db = DatabaseQuery::new();
       $db->setQuery($query);
       $db->setParameters([$result->id]);
       $result->{$this->table} = $db->execute();
    }
    public function fetch(){
        $query = "SELECT * FROM {$this->table} WHERE {$this->foreignKeyName} = ?";
        $db = DatabaseQuery::new();
        $db->setQuery($query);
        $db->setParameters([$this->id]);
        dd($this->id);
        return $db->execute();
    }

}