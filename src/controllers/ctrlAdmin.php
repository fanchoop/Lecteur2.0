<?php
require('src/models/Music.php');
if (isset($_GET['action'])){

    if (isset($_GET['id'])) {
        switch($_GET['action']){
            case $_GET['action'] == 'put':
                include_once "src/views/admin-update.php";
                break;
            default:
                include_once "src/views/admininistration.php";
        }
    }
    else {
        switch($_GET['action']) {
            case $_GET['action'] == 'add':
                include_once "src/views/admin-add.php";
                break;
            case $_GET['action'] == 'list':
                include_once "src/views/admin-list.php";
                break;
            default:
                include_once "src/views/admininistration.php";
        }
    }

}elseif(isset($_GET['id'])) {
    
}
else {
    include "src/views/administration.php";
}
