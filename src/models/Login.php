<?php

namespace src\models;
use src\models\db\User;

class Login
{
    /**
     * Fonction de connexion
     * @param $ident
     * @param $mdp
     * @return bool
     * @throws \Exception
     */
    public static function login($ident, $mdp){

        $cnx = false;

        /* On récupere les informations liées de l'utilisateur */
        $user = User::findByLogin($ident);

        if(!$user){
            throw new \Exception("L'utilisateur n'existe pas");
        }
        else{
            $userMdp = $user->getMd5_password();
            $md5mdp = md5($mdp);

            if($userMdp === $md5mdp){
                /**
                 * Connexion acceptée
                 */
                $_SESSION["id"] = $user->getId();
                $_SESSION["login"] = $user->getLogin();
                $_SESSION["email"] = $user->getEmail();

                $cnx = true;
            }
            else{
                throw new \Exception("Mot de passe invalide");
            }
        }

        return $cnx;
    }

    /**
     * @return bool
     */
    public static function checkUser(){
        if( empty($_SESSION["id"]) OR empty($_SESSION["login"]) OR empty($_SESSION["email"])){
            $return = false;
        }
        else{
            $return = true;
        }
        return $return;
    }

    /**
     * Fonction de déconnexion
     */
    public static function logout(){
        /* On unset les variables de session */
        unset($_SESSION["id"]);
        unset($_SESSION["login"]);
        unset($_SESSION["email"]);
    }
}