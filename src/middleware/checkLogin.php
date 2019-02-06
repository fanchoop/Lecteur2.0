<?php
/* Requires */
require('src/models/Login.php');

use src\models\Login;

/**
 * On verifie si l'utilisateur est connectée
 */
if(Login::checkUser() === false){
    header("Location: http://$host$uri/index.php?page=login");
    die();
}