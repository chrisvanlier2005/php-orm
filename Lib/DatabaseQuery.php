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

    /**
     * @throws \Exception
     */
    public function execute(){
        $stmt = $this->PDO->prepare($this->query);
        // dump complete query with parameters
        try {
            $stmt->execute($this->parameters);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }


        return $stmt->fetchAll(\PDO::FETCH_CLASS);

        //return $this->PDO->execute($this->parameters);
    }

    public function lastInsertId($table){
        $stmt = $this->PDO->query("SELECT LAST_INSERT_ID() from {$table}");
        return $stmt->fetchColumn();
    }





}