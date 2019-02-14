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
        $script = "\nvar music".$music->getId()." = new Music (".$music->convertJson().");\n";
        $script .= "player".$this->id.".addMusicObject("."music".$music->getId().");\n";
        array_push($this->tracks,  $script);
    }

    public function getHtml(){

        echo "<article id='player$this->id'>\n";
        echo "<h2>$this->title</h2>\n";
        echo "Voici le player :";
        $this->parsePlayerHtml();
        echo $this->html;
        echo "</article>\n";
        $script = "\n var player".$this->id." = new Player(document.querySelector('#player".$this->id." .audioplayer'));\n";
        foreach ($this->tracks as $track){
            $script .= $track."\n";
        }

        HtmlDocument::getCurrentInstance()->addScript($script, HtmlDocument::LAST);
    }
}