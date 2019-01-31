<?php

namespace src\db\models;

/**
 * Class Artist
 * @package src\db\models
 */
class Artist extends Entity {

    CONST TABLENAME = 'profil_profils_artistes';
    CONST PKNAME = 'id';
    private $id;
    private $nom;

    /**
     * Constructeur de l'objet Artiste, qui prend en paramètre le nom de l'artiste.
     * Paramètre optionnel : identifiant de l'artiste.
     * @param string $nom
     * @param int|null $id
     */
    public function __construct(string $nom, int $id = null) {
        parent::__construct(self::$tableName, self::$pkName);

        $this->id = $id;
        $this->nom = nom;
    }

    /**
     * Récupère la totalité de la table contenant les artistes.
     * @return un tableau contenant tous les artistes.
     */
    public static function findAll() {
        $connexion = new DAO();
        $sql = "SELECT * FROM ".self::TABLENAME;
        $prepareStatement = $connexion::getInstance()->prepare($sql);
        $prepareStatement->execute();
        $ligne = $prepareStatement->fetch(PDO::FETCH_ASSOC);

        while ($ligne) {
            $artist = new Artist();

            $artist->hydrate([
                'id' => intVal($ligne['id']),
                'nom' => $ligne['nom']
            ]);

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
    public static function find($id_artist) {
        $connexion = new DAO();

        $sql = "SELECT * FROM ".self::TABLENAME." WHERE ".self::PKNAME." = :id_artist";

        $prepareStatement = $connexion::getInstance()->prepare($sql);
        $prepareStatement->bindValue(":id_artist",$id_artist, PDO::PARAM_STR);

        $prepareStatement->execute();
        $ligne = $prepareStatement->fetch(PDO::FETCH_ASSOC);

        $artist = new Artist();

        $artist->hydrate([
            'id' => intVal($ligne['id']),
            'nom' => $ligne['nom']
        ]);

        $connexion::close();
        return $artist;
    }
}