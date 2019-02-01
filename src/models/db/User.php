<?php

namespace src\models\db;
include_once "src/models/db/Entity.php";

use PHPUnit\Runner\Exception;

class User extends Entity {

    const TABLE_NAME = "pers_personnes";
    const PK_NAME = "id";

    /**
     * User constructor.
     * @param string $date_inscription
     * @param string $login
     * @param string $md5_password
     * @param string $nom
     * @param string $prenom
     * @param string $email
     * @param int|null $id
     * 
     * note : regex valide jusqu'en 2029
     * 
     */
    public function __construct(string $date_inscription, string $login, string $md5_password,
                                string $nom, string $prenom, string $email, int $id = null){

        if (!preg_match('/'.'^(201[9]|202[0-9])-(0[1-9]|1[0-2])-(0[1-9]|1[0-9]|2[0-9]|3[0-1]) ([0-1][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/', $date_inscription)) {

            throw new Exception('Date incorrect.');
        }

        elseif(!preg_match('/'.'^[a-f0-9]{32}$/i', $md5_password)) {
            throw new Exception('Format Password incorrect.');
        }

        elseif (!preg_match('#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i', $email)) {
            throw new Exception('Email incorrect.');
        }

        $this->hydrate([
            'id' => $id,
            'date_inscription' => $date_inscription,
            'login' => $login,
            'md5_password' => $md5_password,
            'email' => $email,
            'nom' => $nom,
            'prenom' => $prenom
        ]);
    }
}
