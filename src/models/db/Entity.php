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

    public function getValues() : array {
        return $this->values;
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
            if(!strpos(",", $this->pkName)){
                if($key != $this->pkName) $update .= ", $key = :$key";
            }
            else{
                $pkNames = explode(',', $this->pkName);
                if(in_array($key, $pkNames)) $update .= ", $key = :$key";
            }
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

        if(!strpos(",", $this->pkName)){
            $prepare = "DELETE FROM $this->tableName WHERE $this->pkName = $this->value[$this->pkName]";
        }
        else{
            $pkNames = explode(',', $this->pkName);
            $where = "";
            foreach ($pkNames as $pkname){
                $pkname = trim($pkname);
                $where .= $pkname." = ".$this->values[$pkname].",";
            }
            $where = substr($where, 0, strlen($where) -1);
            $prepare = "DELETE FROM $this->tableName WHERE ".$where;
        }

        $query = $cnx::getInstance()->prepare($prepare);

        $query->execute();
        //var_dump($query->debugDumpParams());
        $cnx::close();
    }
}