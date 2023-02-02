<?php
namespace Chrisvanlier2005;

class BelongsTo extends BaseRelation
{
    protected $localKeyName;
    public function __construct($model_class, $foreignKeyName, $localKeyName, $table = null, $instance = null){
        parent::__construct($model_class, $foreignKeyName, $table, $instance);

        $this->localKeyName = $localKeyName;
        $this->instance = $instance;
    }
    public function execute_relation(&$result, QueryType $type, $relation_primary_key = "id"){

        if ($type == QueryType::SINGLE)
        {
            return $this->fetchSingle($result, $relation_primary_key);
        }
        return $this->fetchMultiple($result, $relation_primary_key);
    }

    protected function fetchMultiple(&$results, $relation_primary_key){
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

        $this->sort_items($results, $manyResults, $relation_primary_key);
    }

    protected function fetchSingle(&$result){
        $query = "SELECT * FROM {$this->table} WHERE {$this->foreignKeyName} = ?";
        $db = DatabaseQuery::new();
        $db->setQuery($query);
        $db->setParameters([$result->{$this->localKeyName}]);
        $result->{$this->table} = $db->execute();

    }

    public function fetch()
    {
        $query = "SELECT * FROM {$this->table} WHERE {$this->foreignKeyName} = ?";
        $db = DatabaseQuery::new();

        $db->setQuery($query);
        $db->setParameters([$this->id]);

        return $db->execute();
    }
}

