<?php
include_once "src/models/HtmlDocument.php";
!empty($_GET['page']) ? $page = $_GET['page'] : $page = null;

$html = new HtmlDocument($page);
$html->render();
