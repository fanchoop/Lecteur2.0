<?php

namespace src\models\db;
use Exception;
use PDO;

class DAO
{
    private static $dao = null;
    const host = "localhost";
    const user = "user";
    const mdp = "user";

    public function __construct($nameBdd = "lecteur"){
        if(self::$dao != null) throw new Exception("Classe déjà instancié");

        self::$dao = new PDO ("mysql:host=" . self::host . ";dbname=" . $nameBdd.';charset=utf8', self::user, self::mdp);
    }

    public static function getInstance(){
        return self::$dao;
    }

    public static function close(){
        self::$dao = null;
    }
}