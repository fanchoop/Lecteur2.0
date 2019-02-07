<?php
session_start();

include_once "src/models/HtmlDocument.php";

use src\models\HtmlDocument;

!empty($_GET['page']) ? $page = $_GET['page'] : $page = "player";

/* Initialisation des variables utiles à la redirection */
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

$html = new HtmlDocument($page);
$html->render();