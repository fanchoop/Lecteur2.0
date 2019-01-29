<?php
/**

    "/" Player
    "/embed" Code partagaeble
    "/findAll" Retourne toute les musiques
    "/find/id/:id" Trouver par un ID
    "/find/title/:title" Trouver par un titre
    "/find/artiste/:artiste" Trouver par un artiste
    "/find/album/:album" Trouver par un album
    "/find/genre/:genre" Trouver par un genre
    "/find/annee/:annee" Trouver par une année
    "/add" Ajouter une musique dans la bdd
    "/maj/:id" Update d'un titre dans la bdd
    "/maj/like" Ajout d'un like dans la bdd
    "/maj/removeLike/:id" Supprime un like dans la bdd
    "/maj/views/:id" Ajoute une vue dans la bdd
    "/maj/removeViews/:id" Supprime une vue dans bdd
    "/remove/:id" Supprime une musique suivant l'id
*/
class Music {

    private $_id;
    private $_title;
    private $_artist;
    private $_album;
    private $_genre;
    private $_annee;
    private $_like;
    private $_view;

    public function __construct($title,$artist){

        $this->_id = 0;
        $this->_title = $title;
        $this->_artist = $artist;
        $this->_album = "";
        $this->_genre = [];
        $this->_annee = 0;
        $this->_like = 0;
        $this->_view = 0;

    }

    //id

    public function getId() : int {

        return $this->_id;

    }

    public function setId($newId){

        $this->_id = $newId;

    }

    //title

    public function getTitle() : string {

     return $this->_title;

    }

    public function setTitle($newTitle){

        $this->_title = $newTitle;

    }

    //artist

    public function getArtist() : string {

        return $this->_artist;

    }

    public function setArtist($newArtist){

        $this->_artist = $newArtist;

    }

    //album

    public function getAlbum() : string {

        return $this->_album;

    }

    public function setAlbum($newAlbum){

        $this->_album = $newAlbum;

    }

    //genre

    public function getGenre() : array {

        return $this->_genre;

    }

    public function setGenre($newGenre){

        $this->_genre = array_push($this->_genre, $newGenre);

    }

    //annee

    public function getAnnee() : int {

        return $this->_annee;

    }

    public function setAnnee($newAnnee){

        $this->_annee = $newAnnee;

    }

    //like

    public function getLike() : int {

        return $this->_like;

    }

    public function setLike($newLike){

        $this->_like = $newLike;

    }

    public function addLike(){

        $this->_like = $this->_like + 1;

    }

    public function deleteLike(){

        $this->_like = $this->_like - 1;

    }

    //view

    public function getView() : int {

        return $this->_view;

    }

    public function setView($newView){

        $this->_view = $newView;

    }

    public function addView(){

        $this->_view = $this->_view + 1;

    }

}
?>