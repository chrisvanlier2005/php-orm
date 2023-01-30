<?php
namespace Chrisvanlier2005;
class DatabaseQuery
{
    protected $PDO;
    protected $query;
    protected $table;
    protected $parameters = [];
    public static function new(){
        $db = new DatabaseQuery();
        $db->connect("orm", "root", "root");
        return $db;
    }

    public function setQuery($query){
        $this->query = $query;
        return $this;
    }

    public function setParameters($parameters){
        $this->parameters = $parameters;
        return $this;
    }

    public function connect($database_name, $username, $password, $host = 'localhost'){
        $this->PDO = new \PDO("mysql:dbname={$database_name};host={$host}", $username, $password);
        return $this;
    }

    public function execute(){
        $stmt = $this->PDO->prepare($this->query);
        $stmt->execute($this->parameters);
        return $stmt->fetchAll(\PDO::FETCH_CLASS);

        //return $this->PDO->execute($this->parameters);
    }


}