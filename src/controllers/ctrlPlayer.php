<?php
include_once("src/models/Player.php");

use src\models\HtmlDocument;
use src\models\Player;

$player = new player(1, "Player 1");
$player->getHtml();

$player = new player(2, "Player 2");
$player->getHtml();

$player = new player(3, "Player 3");
$player->getHtml();

$player = new player(4, "Player 4");
$player->getHtml();

$player = new player(5, "Player 5");
$player->getHtml();
