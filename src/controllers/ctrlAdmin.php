<?php

/* Requires */
require('src/models/db/Music.php');
require('src/views/nav.html');

use src\models\db\Music;

/* Initialisation des variables utiles à la redirection */
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'index.php?page=admin';

/**
 * Si une action est demandée
 */
if (isset($_GET['action'])){

    switch($_GET['action']) {

        /**
         * Cas de demande d'ajout d'une
         * musique par l'utilisateur
         */
        case $_GET['action'] == 'add':
            include_once "src/views/admin-add.php";
            break;

        /**
         * Cas de demande de lister
         * les musiques par l'utilisateur
         */
        case $_GET['action'] == 'list':

            try{
                $musics = Music::findAll();
            }
            catch (Exception $e){
                echo $e->getMessage();
            }

            $list = "";
            foreach ($musics as $music){
                /* Création du tableau de music */
                $list .= "
                    <li class=\"element\">
                        <img class=\"image\" src='".$music->getChemin_mp3()."'/>
                        <p class=\"id\">".$music->getId()."</p>
                        <p class=\"titre\">".$music->getLibelle()."</p>
                        <p class=\"artiste\">".$music->getArtiste_original()."</p>
                        <p class=\"album\">".$music->getId_album()."</p>
                        <p class=\"genre\">".$music->getId_style()."</p>
                        <p class=\"annee\">".$music->getId_album()."</p>
                        <a class=\"modif\" href=\"index.php?page=admin&action=put&id=".$music->getId()."\">Modification</a>
                        <a class=\"suppr\" href=\"index.php?page=admin&action=delete&id=".$music->getId()."\">Supprimer</a>
                    </li>";
            }

            include_once "src/views/admin-list.php";
            break;

        /**
         * Cas de demande de modification
         * d'une musiques par l'utilisateur
         */
        case $_GET['action'] == 'put':
            /* On verifie qu'un id est bien renseigné */
            if (isset($_GET['id'])) {
                include_once "src/views/admin-update.php";
            }
            /* Sinon On redirige vers la page d'accueil */
            else{
                header("Location: http://$host$uri/$extra");
            }
            break;

        /**
         * Cas de demande de modification
         * d'une musiques par l'utilisateur
         */
        case $_GET['action'] == 'delete':
            /* On verifie qu'un id est bien renseigné */
            if (isset($_GET['id'])) {
                include_once "src/views/admin-update.php";
            }
            /* Sinon On redirige vers la page d'accueil */
            else{
                header("Location: http://$host$uri/$extra");
            }
            break;
        default:

            /**
             * Dans le cas où la requête n'est pas pris en compte dans
             * les possibilitées on redirige vers la page d'accueil
            */
            header("Location: http://$host$uri/$extra");
    }

}
/**
 * Si Aucune action n'est demandé
 * mais une id est renseigné alors
 * on renvoi un json de la musique
 * demandée.
 */
elseif(isset($_GET['id'])) {
    
}
/**
 * Page d'accueil de l'administration
 */
else {
    include "src/views/administration.php";
}
