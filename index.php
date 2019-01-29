<?php
include_once "src/models/HtmlDocument.php";
use src\models\HtmlDocument;
!empty($_GET['page']) ? $page = $_GET['page'] : $page = null;

$html = new HtmlDocument($page);
$html->render();
