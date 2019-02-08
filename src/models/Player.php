<?php

namespace src\models;

use src\models\db\Music;

include_once("src/models/db/Music.php");

class Player
{
    private $id;
    private $html;
    private $title;
    private $tracks;

    public function __construct(int $id, string $titre)
    {
        $this->html = null;
        $this->tracks = [];
        $this->id = $id;
        $this->title = $titre;
    }

    private function parsePlayerHtml(){
        ob_start();
        include "src/views/player.php";
        $this->html = ob_get_contents();
        ob_end_clean();
    }

    public function addTrack(Music $music){
        $script = "var music = new Music".$music->getId()." (".$music->convertJson().");";
        $script .= "player".$this->id.".addMusicObject("."Music".$music->getId().");";
        array_push($this->tracks,  $script);
    }

    public function getHtml(){

        echo "<article id='player$this->id'>";
        echo "<h2>$this->title</h2>";
        echo "Voici le player :";
        $this->parsePlayerHtml();
        echo $this->html;
        echo "</article>";
        $script = " var player".$this->id." = new Player(document.querySelector('#player".$this->id." .audioplayer'));";
        var_dump($this->tracks);

        foreach ($this->tracks as $track){
            $script .= $track;
        }

        HtmlDocument::getCurrentInstance()->addScript($script, HtmlDocument::LAST);
    }
}