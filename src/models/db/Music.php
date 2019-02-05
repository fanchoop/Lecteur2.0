<?php

namespace src\models\db;

session_start();

use Exception;
use PDO;

include_once "src/models/db/Entity.php";
include_once "src/models/db/DAO.php";

class Music extends Entity {

    const TABLE_NAME = "mp3_fichiers";
    const PK_NAME = "id";

    public function __construct(int $id_album ,int $id_style,int $id_profil_artiste, string $libelle, array $liste_point,
                              string $chemin_mp3, string $chemin_pochette, string  $artiste_original, bool $composition,
                              int $taille, string $duree, int $nb_ecoutes, string $dateInsertion, int $id = null){

        parent::__construct(self::TABLE_NAME, self::PK_NAME);
        $this->hydrate(array(
            'id' => $id,
            'id_album' => $id_album,
            'id_style' => $id_style,
            'id_profil_artiste' => $id_profil_artiste,
            'libelle' => $libelle,
            'liste_points' => $liste_point,
            'chemin_mp3' => $chemin_mp3,
            'chemin_pochette' => $chemin_pochette,
            'artiste_original' => $artiste_original,
            'composition' => $composition,
            'taille' => $taille,
            'duree' => $duree,
            'nb_ecoutes' => $nb_ecoutes,
            'date_insertion' => $dateInsertion
        ));
    }

    public function convertJson(){
        return json_encode($this->values);
    }

    /**
     * Méthode d'ajout d'un like dans la base de données
     * Cette méthode ajout un like sur un musique via un user
     */
    public function addLike(){
        $ecoute = Ecoute::find( $_SESSION["id"], $this->getId());
        $ecoute->setIs_liked(1);
        $ecoute->save();
    }

    /**
     * Méthode de suppression d'un like.
     */
    public function deleteLike(){
        $ecoute = Ecoute::find( $_SESSION["id"], $this->getId());
        $ecoute->setIs_liked(0);
        $ecoute->save();
    }

    /**
     * Méthode d'ajout d'une écoute.
     */
    public function addListen(){
        $this->setNb_ecoutes($this->getNb_ecoutes() + 1);
    }

    /**
     * Méthode de suppression d'une écoute.
     */
    public function deleteListen(){
        $this->setNb_ecoutes($this->getNb_ecoutes() - 1);
    }

    /**
     * Méthode findAll pour récupérer toutes les
     * musiques de la bdd
     * @return array Music[]
     * @throws \Exception
     */
    public static function findAll() : array {

        $musics = array();

        $connexion = new DAO();
        $sql = "SELECT * FROM ".self::TABLE_NAME;
        $prepareStatement = $connexion::getInstance()->prepare($sql);
        $prepareStatement->execute();
        $ligne = $prepareStatement->fetch(PDO::FETCH_ASSOC);

        while ($ligne) {
            $music = new Music(
                intval($ligne['id_album']), intval($ligne['id_style']), intval($ligne['id_profil_artiste']),
                strval($ligne['libelle']), (array) $ligne['liste_points'], strval($ligne['chemin_mp3']),
                strval($ligne['chemin_pochette']), strval($ligne['artiste_original']), boolval($ligne['composition']),
                intval($ligne['taille']), strval($ligne['duree']), intval($ligne['nb_ecoutes']),
                strval($ligne['date_insertion']), intval($ligne['id'])
            );

            $musics[] = $music;

            $ligne = $prepareStatement->fetch(PDO::FETCH_ASSOC);
        }
        $connexion::close();

        return $musics;
    }

    /**
     * Méthode find pour récuperer une musique selon
     * sont ID.
     * @param int id
     * @return Music music
     * @throws \Exception
     */
    public static function find(int $idMusic) : Music{
        $music = null;

        $connexion = new DAO();

        $sql = "SELECT * FROM ".self::TABLE_NAME." WHERE ".self::PK_NAME." = :id_Music";

        $prepareStatement = $connexion::getInstance()->prepare($sql);
        $prepareStatement->bindValue(":id_Music",$idMusic, PDO::PARAM_STR);

        $result = $prepareStatement->execute();

        if($result){
            $ligne = $prepareStatement->fetch(PDO::FETCH_ASSOC);

            $music = new Music(
                intval($ligne['id_album']), intval($ligne['id_style']), intval($ligne['id_profil_artiste']),
                strval($ligne['libelle']), (array) $ligne['liste_points'], strval($ligne['chemin_mp3']),
                strval($ligne['chemin_pochette']), strval($ligne['artiste_original']), boolval($ligne['composition']),
                intval($ligne['taille']), intval($ligne['duree']), intval($ligne['nb_ecoutes']),
                strval($ligne['date_insertion']), intval($ligne['id'])
            );
        }

        DAO::close();

        return $music;
    }
}