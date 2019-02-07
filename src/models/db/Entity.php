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

        /**
         * On parcours le tableau de valeurs.
         */
        foreach ($this->values as $key => $value){
            $columns[$i] = $key;

            /**
             * Modification de la values : si celle-ci est
             * un tableau on la convertie en json.
             */
            if(is_array($value)){
                $this->values[$key] = json_encode($value);
            }

            $datas[$i] = $value;

            if($key != $this->pkName) $update .= ", $key = :$key";

            $i++;
        }

        //Connexion à la bdd
        $cnx = new DAO();

        //Création de la requête SQL
        $prepare = "INSERT INTO $this->tableName (".implode(',', $columns).") VALUES ( :".implode(', :', $columns).") ON DUPLICATE KEY UPDATE ".substr($update, 1);

        //Préparation de la requête
        $query = $cnx::getInstance()->prepare($prepare);

        //On execute la requête et on passe ne param les valeurs à binder.
        $result =  $query->execute($this->values);

        //$query->debugDumpParams();

        //Fermeture de la connexion
        DAO::close();

        return $result;
    }

    public function delete(){

        $cnx = new DAO();

        if(!strpos($this->pkName, ",")){
            $prepare = "DELETE FROM $this->tableName WHERE $this->pkName = ".$this->values[$this->pkName];
        }
        else{
            $pkNames = explode(',', $this->pkName);
            $where = "";
            foreach ($pkNames as $pkname){
                $pkname = trim($pkname);
                $where .= $pkname." = ".$this->values[$pkname]." AND ";
            }
            $where = substr($where, 0, strlen($where) -5);
            $prepare = "DELETE FROM $this->tableName WHERE ".$where;
        }

        $query = $cnx::getInstance()->prepare($prepare);

        $result = $query->execute();

        DAO::close();

        return $result;
    }
}