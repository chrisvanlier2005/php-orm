<?php
namespace Chrisvanlier2005;

class BelongsTo extends BaseRelation
{
    protected $localKeyName;
    public function __construct($model_class, $foreignKeyName, $localKeyName, $table = null){
        parent::__construct($model_class, $foreignKeyName, $table);
        $this->localKeyName = $localKeyName;
    }
    public function execute_relation(&$result, QueryType $type, $relation_primary_key = "id"){

        if ($type == QueryType::SINGLE)
        {
            return $this->fetchSingle($result, $relation_primary_key);
        }
        return $this->fetchMultiple($result, $relation_primary_key);
    }

    public function fetchMultiple(&$results, $relation_primary_key){
        $childIds = [];
        foreach ($results as $result)
        {
            $childIds[] = $result->{$this->localKeyName};
        }
        $query = "SELECT * FROM {$this->table} WHERE {$relation_primary_key} IN (";
        $query .= implode(',', $childIds);
        $query .= ")";
        $db = DatabaseQuery::new();
        $db->setQuery($query);
        $manyResults = $db->execute();
        foreach ($manyResults as $manyResult)
        {
            foreach ($results as $result)
            {
                if ($manyResult->{$relation_primary_key} == $result->{$this->localKeyName})
                {
                    $result->{$this->table} = $manyResult;
                }
            }
        }
    }

    public function fetchSingle(&$result, $relation_primary_key){
        $query = "SELECT * FROM {$this->table} WHERE {$relation_primary_key} = ?";
        $db = DatabaseQuery::new();
        $db->setQuery($query);
        $db->setParameters([$result->{$this->localKeyName}]);
        $result->{$this->table} = $db->execute();

    }
}

