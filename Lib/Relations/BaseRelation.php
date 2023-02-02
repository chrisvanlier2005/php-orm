<?php
namespace Chrisvanlier2005;
use ReflectionClass;
use ReflectionException;

class BaseRelation
{
    protected $foreignKeyName;
    public $table;
    public $id;
    public $instance;

    /**
     * @throws ReflectionException
     */
    public function __construct($model_class, $foreignKeyName ,$table = null, $instance = null){
        if(!$table){
            $reflectionObject = new ReflectionClass($model_class);
            $table = strtolower($reflectionObject->getShortName()) . 's';
        }
        $this->table = $table;
        $this->foreignKeyName = $foreignKeyName;
        if($instance){

            $this->id = $instance->{$instance->getPrimaryKey()};
           // $this->instance = $instance;
        }
    }

    /**
     * @throws \Exception
     */
    protected function fetchSingle(&$result){
        throw new \Exception("fetchSingle Not implemented");
    }

    /**
     * @throws \Exception
     */
    protected function fetchMultiple(&$results, $relation_primary_key){
        throw new \Exception("fetchMultiple Not implemented");
    }


    /**
     * @return mixed
     * @throws \Exception
     */
    protected function fetch(){
        throw new \Exception("Fetch not implemented in relation");
    }

    /**
     * Alternative syntax for fetch(), does the same thing.
     * @return mixed
     * @throws \Exception
     */
    public function get()
    {
        return $this->fetch();
    }

    protected function sort_items(&$input_result, &$relation_result, $key_name)
    {
        foreach($input_result as $result)
        {
            $result->{$this->table} = [];
            foreach($relation_result as $relation)
            {

                if($relation->{$this->foreignKeyName} == $result->{$key_name})
                {
                    $result->{$this->table}[] = $relation;
                }
            }
        }
    }

    /**
     * @throws \Exception
     */
    protected function single_query($query, $parameters)
    {
        $db = DatabaseQuery::new();
        $db->setQuery($query);
        $db->setParameters($parameters);
        return $db->execute();
    }

    public function count()
    {
        $query = "SELECT COUNT(*) FROM {$this->table} WHERE {$this->foreignKeyName} = ?";
        return $this->single_query($query, [$this->id]);
    }

    public function first()
    {
        $query = "SELECT * FROM {$this->table} WHERE {$this->foreignKeyName} = ? LIMIT 1";
        return $this->single_query($query, [$this->id]);
    }
}