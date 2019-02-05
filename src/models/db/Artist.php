<?php

namespace src\models\db;
include_once "src/models/db/Entity.php";

use PDO;

/**
 * Class Artist
 * @package src\db\models
 */
class Artist extends Entity {

    CONST TABLENAME = 'profil_profils_artistes';
    CONST PKNAME = 'id';

    /**
     * Constructeur de l'objet Artiste, qui prend en paramètre le nom de l'artiste.
     * Paramètre optionnel : identifiant de l'artiste.
     * @param string $nom
     * @param int|null $id
     */
    public function __construct(string $nom, int $id = null) {
        parent::__construct(self::TABLENAME, self::PKNAME);

        $this->hydrate(array(
            'id' => $id,
            'nom' => $nom
        ));
    }

    /**
     * Récupère la totalité de la table contenant les artistes.
     * @return un tableau contenant tous les artistes.
     */
    public static function findAll() : array {
        $connexion = new DAO();
        $sql = "SELECT * FROM ".self::TABLENAME;
        $prepareStatement = $connexion::getInstance()->prepare($sql);
        $prepareStatement->execute();
        $ligne = $prepareStatement->fetch(PDO::FETCH_ASSOC);

        while ($ligne) {
            $artist = new Artist( $ligne['nom'], intVal($ligne['id']));

            $artists[] = $artist;

            $ligne = $prepareStatement->fetch(PDO::FETCH_ASSOC);
        }
        $connexion::close();
        return $artists;
    }

    /**
     * On recherche dans la base de donnée un artiste en fonction de son id de BD.
     * @param $id_artist
     * @return un artiste
     */
    public static function find($id_artist) : Artist{
        $connexion = new DAO();

        $sql = "SELECT * FROM ".self::TABLENAME." WHERE ".self::PKNAME." = :id_artist";

        $prepareStatement = $connexion::getInstance()->prepare($sql);
        $prepareStatement->bindValue(":id_artist",$id_artist, PDO::PARAM_STR);

        $prepareStatement->execute();
        $ligne = $prepareStatement->fetch(PDO::FETCH_ASSOC);

        $artist = new Artist($ligne['nom'], intval($ligne['id']));

        $connexion::close();

        return $artist;
    }
}