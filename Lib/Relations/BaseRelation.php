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
        throw new \Exception("Not implemented");
    }

    /**
     * @throws \Exception
     */
    protected function fetchMultiple(&$results, $relation_primary_key){
        throw new \Exception("Not implemented");
    }
}