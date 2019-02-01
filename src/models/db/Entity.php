<?php
namespace src\models\db;

class Entity{

    protected $tableName;
    protected $pkName;
    protected $values;

    protected function __construct(string $tableName, string $pkName){
        $this->tableName = $tableName;
        $this->pkName = $pkName;
    }

    protected function hydrate($values){
        $this->values = $values;
    }

    public function __call(string $method, array $params){

        $function = substr($method,0 ,3);
        $columsName = strtolower( substr($method, 3) );

        if($function === "set"){
            $this->values[$columsName] = $params[0];
            return true;
        }
        elseif($function === "get"){
            return $this->values[$columsName];
        }

        return false;
    }

    public function save(){

        $update = "";
        $i = 0;
        foreach ($this->values as $key => $value){
            $columns[$i] = $key;
            $datas[$i] = $value;
            if($key != $this->pkName) $update .= ", $key = :$key";
            $i++;
        }

        $cnx = new DAO();

        $prepare = "INSERT INTO $this->tableName (".implode(',', $columns).") VALUES ( :".implode(', :', $columns).") ON DUPLICATE KEY UPDATE ".substr($update, 1);

        $query = $cnx::getInstance()->prepare($prepare);

        $query->execute($this->values);
        $cnx::close();

    }

    public function delete(){

        $cnx = new DAO();

        $prepare = "DELETE FROM $this->tableName WHERE $this->pkName = $this-value[$this->pkName]";

        $query = $cnx::getInstance()->prepare($prepare);

        //$query->execute();
        var_dump($query->debugDumpParams());
        $cnx::close();
    }
}