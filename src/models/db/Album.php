<?php

namespace src\models\db;
include_once "src/models/db/Entity.php";

use PDO;
use src\models\db\Entity;
use src\models\db\Artist;

class Album extends Entity{

    const TABLE_NAME = "mp3_albums";
    const PK_NAME = "id";

    public function __construct(int $idArtiste, string $titre, string $date, int $id =null)
    {
        parent::__construct(self::TABLE_NAME, self::PK_NAME);

        $this->hydrate(array(
            "id" => $id,
            "id_profil_artiste" => $idArtiste,
            "titre" => $titre,
            "date" => $date
        ));

    }

    public static function find($id_album){
        $connexion = new DAO();

        $sql = "SELECT * FROM ".self::TABLE_NAME." WHERE id = :id";

        $prepareStatement = $connexion::getInstance()->prepare($sql);
        $prepareStatement->bindValue(":id", $id_album, PDO::PARAM_INT);

        $prepareStatement->execute();
        $ligne = $prepareStatement->fetch(PDO::FETCH_ASSOC);

        $album = new Album($ligne["id_profil_artiste"], $ligne["titre"], $ligne["date"], $ligne["id"]);

        $connexion::close();
        return $album;
    }

    public static function findAll(){
        $connexion = new DAO();

        $sql = "SELECT * FROM ".self::TABLE_NAME;

        $prepareStatement = $connexion::getInstance()->prepare($sql);

        $prepareStatement->execute();
        $ligne = $prepareStatement->fetch(PDO::FETCH_ASSOC);

        while ($ligne) {
            $albums[] = new Album($ligne["id_profil_artiste"], $ligne["titre"], $ligne["date"], $ligne["id"]);

            $ligne = $prepareStatement->fetch(PDO::FETCH_ASSOC);
        }

        $connexion::close();
        return $albums;
    }
}