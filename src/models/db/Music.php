<?php

namespace src\models\db;
include_once "src/models/db/Entity.php";

class Music extends Entity {

    const TABLE_NAME = "mp3_fichiers";
    const PK_NAME = "id";
    private $id;
    private $id_album;
    private $id_style;
    private $id_profil_artiste;
    private $id_licence = 4;
    private $libelle;
    private $liste_point;
    private $chemin_mp3;
    private $chemin_pochette;
    private $artiste_original;
    private $composition;
    private $taille;
    private $duree;
    private $nb_ecoutes;
    private $nb_telechargements = 0;
    private $date_insertion;

    public function __construct(int $id_Album ,int $id_style,int $id_profil_artiste, string $libelle, array $liste_point,
                              string $chemin_mp3, string $chemin_pochette, string  $artiste_original, bool $composition,
                              int $taille, int $duree, int $nb_ecoutes, string $dateInsertion, int $id = null){

        parent::__construct(self::TABLE_NAME, self::PK_NAME);

        $this->id_album = $id_Album;
        $this->id_style = $id_style;
        $this->id_profil_artiste = $id_profil_artiste;
        $this->libelle = $libelle;
        $this->liste_point = $liste_point;
        $this->chemin_mp3 = $chemin_mp3;
        $this->chemin_pochette = $chemin_pochette;
        $this->artiste_original = $artiste_original;
        $this->composition = $composition;
        $this->taille = $taille;
        $this->duree = $duree;
        $this->nb_ecoutes = $nb_ecoutes;
        $this->date_insertion = $dateInsertion;
        $this->id = $id;
    }

    public function convertJson(){
        $json = array('id_Album' => $this->id_album, 'id_style' => $this->id_style, 'id_profil_artiste' => $this->id_profil_artiste,
            'libelle' => $this->libelle, 'liste_point' => $this->liste_point, 'chemin_mp3' => $this->chemin_mp3,
            'chemin_pochette' => $this->chemin_pochette, 'artiste_original' => $this->artiste_original,
            'composition' => $this->composition, 'taille' => $this->taille, 'duree' => $this->duree,
            'nb_ecoutes' => $this->nb_ecoutes, 'date_insertion' => $this->date_insertion, 'id' => $this->id);

        return json_encode($json);
    }
}