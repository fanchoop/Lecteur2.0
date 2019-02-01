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
    public function __construct(string $date_inscription, string $login, string $md5_password, string $nom, string $prenom, string $email, int $id = null){

        parent::__construct(self::TABLENAME, self::PKNAME);

        if (!preg_match('/'.'^(201[9]|20[2-9][0-9])-(0[1-9]|1[0-2])-(0[1-9]|1[0-9]|2[0-9]|3[0-1]) ([0-1][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/', $date_inscription)) {

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
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email
        ]);
    }

    /**
     * Récupère la totalité de la table contenant les utilisateurs.
     * @return un tableau contenant tous les utilisateurs.
     */
    public static function findAll() : array {
        $connexion = new DAO();
        $sql = "SELECT * FROM ".self::TABLENAME;
        $prepareStatement = $connexion::getInstance()->prepare($sql);
        $prepareStatement->execute();
        $ligne = $prepareStatement->fetch(PDO::FETCH_ASSOC);

        while ($ligne) {

            $user = new User(intVal($ligne['id']), $ligne['date_inscription'], $ligne['login'], $ligne['md5_password'], $ligne['nom'], $ligne['prenom'], $ligne['email']);
            $users[] = $user;
            $ligne = $prepareStatement->fetch(PDO::FETCH_ASSOC);

        }
        $connexion::close();

        return $users;
    }

    /**
     * On recherche dans la base de donnée un utilisateur en fonction de son id de BD.
     * @param $id_utilisateur
     * @return un utilisateur
     */
    public static function find($id_utilisateur) : User{
        $connexion = new DAO();

        $sql = "SELECT * FROM ".self::TABLENAME." WHERE ".self::PKNAME." = :id_utilisateur";

        $prepareStatement = $connexion::getInstance()->prepare($sql);
        $prepareStatement->bindValue(":id_utilisateur",$id_utilisateur, PDO::PARAM_STR);
        $prepareStatement->execute();
        
        $ligne = $prepareStatement->fetch(PDO::FETCH_ASSOC);
        $user = new User(intVal($ligne['id']), $ligne['date_inscription'], $ligne['login'], $ligne['md5_password'], $ligne['nom'], $ligne['prenom'], $ligne['email']);

        $connexion::close();

        return $user;
    }
}
