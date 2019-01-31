<?php

namespace src\db\models;

class Music extends Entity {

    const TABLE_NAME = "mp3_fichiers";
    const PK_NAME = "id";
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

    public function construct(int $id_Album ,int $id_style,int $id_profil_artiste, string $libelle, array $liste_point, string $chemin_mp3, string $chemin_pochette,string  $artiste_original, $composition, $taille, $duree, $nb_ecoutes){

    }
}
?>