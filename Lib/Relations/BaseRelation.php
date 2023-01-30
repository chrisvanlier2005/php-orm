<?php
namespace Chrisvanlier2005;
use ReflectionClass;

class BaseRelation
{
    private $model_class;
    private $foreignKeyName;
    public $table;

    /**
     * @throws ReflectionException
     */
    public function __construct($model_class, $foreignKeyName, $table = null){
        if(!$table){
            $reflectionObject = new ReflectionClass($model_class);
            $table = strtolower($reflectionObject->getShortName()) . 's';
        }
        $this->table = $table;
        $this->model_class = $model_class;
        $this->foreignKeyName = $foreignKeyName;
    }
}