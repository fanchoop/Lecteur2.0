<?php

namespace src\models;
use src\models\db\Music;

include_once("src/models/db/Music.php");

class Player
{
    private $html;

    public function __construct()
    {
        $this->html = null;
    }

    private function parsePlayerHtml(){
        ob_start();
        include "src/views/player.html";
        $this->html = ob_get_flush();
        ob_end_clean();
    }

    public function addTrack(){

    }

    public function getHtml(){
        return $this->html;
    }
}