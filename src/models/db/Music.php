<?php

namespace src\models\db;
include_once "src/models/db/Entity.php";

class Music extends Entity {

    const TABLE_NAME = "mp3_fichiers";
    const PK_NAME = "id";

    public function __construct(int $id_album ,int $id_style,int $id_profil_artiste, string $libelle, array $liste_point,
                              string $chemin_mp3, string $chemin_pochette, string  $artiste_original, bool $composition,
                              int $taille, int $duree, int $nb_ecoutes, string $dateInsertion, int $id = null){

        parent::__construct(self::TABLE_NAME, self::PK_NAME);
        $this->hydrate(array(
            'id_Album' => $id_album,
            'id_style' => $id_style,
            'id_profil_artiste' => $id_profil_artiste,
            'libelle' => $libelle,
            'liste_point' => $liste_point,
            'chemin_mp3' => $chemin_mp3,
            'chemin_pochette' => $chemin_pochette,
            'artiste_original' => $artiste_original,
            'composition' => $composition,
            'taille' => $taille,
            'duree' => $duree,
            'nb_ecoutes' => $nb_ecoutes,
            'date_insertion' => $dateInsertion,
            'id' => $id
        ));
    }

    public function convertJson(){
        return json_encode($this->values);
    }
}