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
$html->addHeader("<link rel=\"stylesheet\" media=\"screen and (min-width: 600px)\" href=\"public/stylesheets/player_mini.css\">", HtmlDocument::LAST);
$html->addFooter("<script src=\"public/javascripts/polyfillClassList.js\"></script>\n", HtmlDocument::FIRST);
$html->addFooter("<script src=\"public/javascripts/script/soundmanager2.js\"></script>\n", HtmlDocument::LAST);
$html->addFooter("<script src=\"public/javascripts/PlayerUtils.js\"></script>\n", HtmlDocument::LAST);
$html->addFooter("<script src=\"public/javascripts/Connexion.js\"></script>\n", HtmlDocument::LAST);
$html->addFooter("<script src=\"public/javascripts/spectre.js\"></script>\n", HtmlDocument::LAST);
$html->addFooter("<script src=\"public/javascripts/Music.js\"></script>\n", HtmlDocument::LAST);
$html->addFooter("<script src=\"public/javascripts/Playlist.js\"></script>\n", HtmlDocument::LAST);
$html->addFooter("<script src=\"public/javascripts/Player.js\"></script>\n", HtmlDocument::LAST);
$html->addFooter("<script src=\"public/javascripts/SuperPlayer.js\"></script>\n", HtmlDocument::LAST);
$html->addFooter("<script src=\"public/javascripts/SuperPlayerDom.js\"></script>\n", HtmlDocument::LAST);
$html->addFooter("<script src=\"serviceWorker.js\"></script>\n", HtmlDocument::LAST);
$html->addFooter("<script src=\"public/javascripts/notification.js\"></script>\n", HtmlDocument::LAST);
$html->render();