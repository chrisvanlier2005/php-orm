<?php

namespace Chrisvanlier2005;

use Exception;
use ReflectionClass;
use ReflectionException;

class BaseRelation
{
    public $table;
    public $id;
    public $instance;
    protected $foreignKeyName;
    protected $model;

    /**
     * @throws ReflectionException
     */
    public function __construct($model_class, $foreignKeyName, $table = null, $instance = null)
    {
        if (!$table) {
            $reflectionObject = new ReflectionClass($model_class);
            $table = strtolower($reflectionObject->getShortName()) . 's';
        }
        $this->table = $table;
        $this->foreignKeyName = $foreignKeyName;
        $this->model = $model_class;
        if ($instance) {

            $this->id = $instance->{$instance->getPrimaryKey()};
            $this->instance = $instance;
        }

    }

    /**
     * Alternative syntax for fetch(), does the same thing.
     * @return mixed
     * @throws Exception
     */
    public function get()
    {
        return $this->fetch();
    }

    /**
     * @return mixed
     * @throws Exception
     */
    protected function fetch()
    {
        throw new Exception("Fetch not implemented in relation");
    }

    /**
     * Returns the number of items in the associated table
     * @return array the result of the query
     * @throws Exception
     */
    public function count()
    {
        $query = "SELECT COUNT(*) FROM {$this->table} WHERE {$this->foreignKeyName} = ?";
        return $this->single_query($query, [$this->id]);
    }

    /**
     * Executes a single query and return the result
     * @param $query string
     * @param $parameters array associative array of parameters
     * @throws Exception
     */
    protected function single_query($query, $parameters)
    {
        $db = DatabaseQuery::new();
        $db->setQuery($query);
        $db->setParameters($parameters);
        return $db->execute();
    }

    /**
     * Returns the first item in the associated table
     * @throws Exception
     */
    public function first()
    {
        $query = "SELECT * FROM {$this->table} WHERE {$this->foreignKeyName} = ? LIMIT 1";
        return $this->single_query($query, [$this->id]);
    }

    /**
     * @throws Exception
     */
    protected function fetchSingle(&$result)
    {
        throw new Exception("fetchSingle Not implemented");
    }

    /**
     * @throws Exception
     */
    protected function fetchMultiple(&$results, $relation_primary_key)
    {
        throw new Exception("fetchMultiple Not implemented");
    }

    /**
     * Adds the relation items to the proper parent item
     * eg. if the relation is a comment, it will add the comment to the post in the "comments" property (array)
     * @param &$input_result array the result of the query
     * @param &$relation_result array the result of the relation query
     * @param &$key_name string the name of the key to compare
     * @return void
     * @throws Exception
     */
    protected function sort_items(&$input_result, &$relation_result, $key_name): void
    {
        foreach ($input_result as $result) {
            $result->{$this->table} = [];
            foreach ($relation_result as $relation) {

                if ($relation->{$this->foreignKeyName} == $result->{$key_name}) {
                    $result->{$this->table}[] = $relation;
                }
            }
        }
    }


    public function attach(array $data){
        throw new Exception("Attach not implemented");
    }
}