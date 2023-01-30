<?php

namespace Chrisvanlier2005;

use Exception;
use HasMany;
use Chrisvanlier2005\BelongsTo;
use ReflectionClass;

enum QueryType {
    case SINGLE;
    case MULTIPLE;
}
class Elegant
{
    public $relations = [];
    protected $table;
    protected $fillable = [];
    protected $hidden = [];
    protected $guarded = [];
    protected $primaryKey = 'id';

    public function __construct()
    {
        $this->table = strtolower($this->get_class_name($this));
        $this->table .= 's';

    }

    private function get_class_name($class): string
    {
        $reflectionObject = new ReflectionClass($class);
        return $reflectionObject->getShortName();
    }

    private function get_relations(&$result){
        $type = QueryType::SINGLE;
        if(!$result instanceof \stdClass){
            $type = QueryType::MULTIPLE;
        }

        foreach($this->relations as $relation)
        {
            $relation = $this->$relation($type);
            $relation->execute_relation($result, $type, $this->primaryKey);
        }
    }

    public static function all()
    {
        $db = DatabaseQuery::new();
        $model = new static();
        $db->setQuery("SELECT * FROM {$model->table}");
        return $db->execute();

    }

    public static function with($relation)
    {
        $model = new static();
        $model->relations[] = $relation;
        return $model;
    }

    /**
     * Adds a hasMany relationship to the model
     * @param $model_class
     * @throws Exception
     */
    public function hasMany($model_class, $foreignKeyName, $table = null)
    {
        $this->validate_class($model_class);
        return new HasMany($model_class, $foreignKeyName, $table);
    }

    public function belongsTo($model_class, $foreignKeyName, $localKeyName, $table = null){
        $this->validate_class($model_class);
        return new BelongsTo($model_class, $foreignKeyName, $localKeyName, $table);
    }

    /**
     * Validate if the model extends the Elegant class
     * @param $model_class
     * @throws Exception
     */
    private function validate_class($model_class): void
    {
        // check if the class extends Elegant
        if (!is_subclass_of($model_class, Elegant::class)) {
            throw new Exception("The class {$model_class} does not extend Elegant");
        }
    }

    /**
     * Adds a hasOne relationship to the model
     * @throws Exception
     */
    public function hasOne($model_class)
    {
        $this->validate_class($model_class);
    }

    public function find($id)
    {
        $baseQuery = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $db = DatabaseQuery::new();
        $db->setQuery($baseQuery);
        $db->setParameters(['id' => $id]);
        $result = $db->execute()[0];

        if (empty($result)) {
            throw new Exception("No record found with id {$id}");
        }

        $this->get_relations($result);
        return $result;
    }

    public function get()
    {
        $baseQuery = "SELECT * FROM {$this->table}";
        $db = DatabaseQuery::new();
        $db->setQuery($baseQuery);
        $results = $db->execute();
        if (empty($results)) {
            throw new Exception("No records found");
        }

        $this->get_relations($results);
        return $results;
    }
}