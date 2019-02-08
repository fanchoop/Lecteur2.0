<?php
include_once("src/models/Player.php");

use src\models\db\Music;
use src\models\Player;

$music = new Music(1, 1, 1, "Extra lucide", [1, 5, 4, 8, 6 ,7],
    "extra_lucide.mp3", "extra_lucide.png", "Disiz", true, 3,
    256, 25, "2015-05-10", 1);

$player = new player(1, "Player 1");
$player->addTrack($music);
$player->getHtml();
/*
$player = new player(2, "Player 2");
$player->getHtml();

$player = new player(3, "Player 3");
$player->getHtml();

$player = new player(4, "Player 4");
$player->getHtml();

$player = new player(5, "Player 5");
$player->getHtml();*/