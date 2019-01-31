<?php

namespace src\models;

use src\db\models\Entity;

class Music extends Entity {

    private $_id;
    private $_title;
    private $_artist;
    private $_album;
    private $_genre;
    private $_annee;
    private $_like;
    private $_view;
    const TABLENAME = "mp3_fichiers";
    const PKNAME = "id";

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

        $this->_genre[] = $newGenre;

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

    public function addView()
    {
        $this->_view = $this->_view + 1;
    }
}
?>