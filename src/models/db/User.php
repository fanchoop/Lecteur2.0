<?php

namespace src\models\db;
include_once "src/models/db/Entity.php";

use PHPUnit\Runner\Exception;

class User extends Entity {

    const TABLE_NAME = "pers_personnes";
    const PK_NAME = "id";

    /**
     * User constructor.
     * @param string $date_inscription
     * @param string $login
     * @param string $md5_password
     * @param string $nom
     * @param string $prenom
     * @param string $email
     * @param int|null $id
     * 
     * note : regex valide jusqu'en 2029
     * 
     */
    public function __construct(string $date_inscription, string $login, string $md5_password,
                                string $nom, string $prenom, string $email, int $id = null){

        if ($this->checkDateTime($date_inscription)) {

            throw new Exception('Date incorrect.');
        }

        elseif(!preg_match('/'.'^[a-f0-9]{32}$/i', $md5_password)) {
            throw new Exception('Format Password incorrect.');
        }

        elseif ($this->checkEmail($email)) {
            throw new Exception('Email incorrect.');
        }

        $this->hydrate([
            'id' => $id,
            'date_inscription' => $date_inscription,
            'login' => $login,
            'md5_password' => $md5_password,
            'email' => $email,
            'nom' => $nom,
            'prenom' => $prenom
        ]);
    }

    // fournit true si $adrMailAvalider est une adresse valide, false sinon
    private static function  checkEmail ($adrMailAvalider)
    {	// utilisation d'une expression régulière pour vérifier une adresse mail :
        $EXPRESSION = "#^.+@.+\..+$#";
        // on retourne true si l'adresse est bonne, mais aussi si l'adresse est vide :
        if ( preg_match ( $EXPRESSION , $adrMailAvalider) == true || $adrMailAvalider == "" ) return true; else return false;
    }

    // fournit true si $laDateAvalider est une date valide (format aaaa-mm-jj), false sinon
    private static function checkDate($laDateAvalider)
    {
        // on retourne false si la date est vide :
        if ( $laDateAvalider == "" ) return false;

        // utilisation d'une expression régulière pour vérifier le format de la date :
        $EXPRESSION = "#^[0-9]{4}-[0-9]{2}-[0-9]{2}$#";
        if ( preg_match ( $EXPRESSION , $laDateAvalider) == false) return false;

        // jusque là, tout va bien ! on extrait les 3 sous-chaines et on les convertit en 3 entiers :
        $chaine1 = substr ($laDateAvalider, 0, 4);
        $chaine2 = substr ($laDateAvalider, 5, 2);
        $chaine3 = substr ($laDateAvalider, 8, 2);
        $an = (int)($chaine1);
        $mois = (int)($chaine2);
        $jour = (int)($chaine3);

        //return "an : ".$an." mois : ".$mois." jour : ".$jour;

        // test des valeurs
        if ( $mois < 0 || $mois > 12 || $jour < 0 || $jour > 31 )
            return false;
        else
        {   // cas des mois de 30 jours
            if ( ( $mois == 4 || $mois == 6 || $mois == 9 || $mois == 11 ) && ( $jour > 30 ) )
                return false;
            else
            {   // cas du mois de février
                // % est l'opérateur modulo ; il permet de tester si $an est multiple de 4, de 100 ou de 400
                if ((($an % 4) == 0 && ($an % 100) != 0) || ($an % 400) == 0)
                    $bissextile = true;
                else
                    $bissextile = false;
                if ( $mois == 2 && $bissextile == false && $jour > 28 )
                    return false;
                else
                {   if ( $mois == 2 && $bissextile == true && $jour > 29 )
                {   return false;
                }
                }
            }
        }

        return true;
    }

    // fournit true si $leDatetime est un dateTime valide (aaaa-mm-jj hh:mm:ss), false sinon
    private static function checkDateTime ($leDateTimeValider){
        $result = false;

        // utilisation d'une expression régulière pour vérifier le format de la date :
        $EXPRESSION = "#^[0-9]{4}(-)[0-9]{1,2}(-)[0-9]{1,2} [0-2][0-9]:[0-5][0-9]:[0-5][0-9]$#";
        if( preg_match( $EXPRESSION , $leDateTimeValider)){ $result = true; }

        $chaine = substr($leDateTimeValider, 0, 10);
        $result2 = Outils::estUneDateValide($chaine);

        $chaine = substr($leDateTimeValider, 11, 2);
        if ( $chaine > 23 ){ $result = false; }

        if ( $result == true && $result2 == true ){ return true; }
        else { return false; }
    }
}
