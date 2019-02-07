<?php
session_start();

include_once "src/models/HtmlDocument.php";

use src\models\HtmlDocument;

!empty($_GET['page']) ? $page = $_GET['page'] : $page = "player";

/* Initialisation des variables utiles à la redirection */
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$html = new HtmlDocument($page);
$html->addHeader("<title>Page Player</title>", HtmlDocument::FIRST);
$html->addHeader("<link rel=\"stylesheet\" media=\"screen and (max-width: 600px)\" href=\"public/stylesheets/player_mobile.css\">", HtmlDocument::LAST);
$html->addHeader("<link rel=\"stylesheet\" media=\"screen and (min-width: 600px)\" href=\"public/stylesheets/player.css\">", HtmlDocument::LAST);
$html->addFooter("<script src=\"public/javascripts/polyfillClassList.js\"></script>", HtmlDocument::FIRST);
$html->addFooter("<script src=\"public/javascripts/script/soundmanager2.js\"></script>", HtmlDocument::LAST);
$html->addFooter("<script src=\"public/javascripts/PlayerUtils.js\"></script>", HtmlDocument::LAST);
$html->addFooter("<script src=\"public/javascripts/Connexion.js\"></script>", HtmlDocument::LAST);
$html->addFooter("<script src=\"public/javascripts/spectre.js\"></script>", HtmlDocument::LAST);
$html->addFooter("<script src=\"public/javascripts/Music.js\"></script>", HtmlDocument::LAST);
$html->addFooter("<script src=\"public/javascripts/Playlist.js\"></script>", HtmlDocument::LAST);
$html->addFooter("<script src=\"public/javascripts/Player.js\"></script>", HtmlDocument::LAST);
$html->render();