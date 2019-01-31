<?php

namespace src\db\models;

class User extends Entity {

    const TABLE_NAME = "pers_personnes";
    const PK_NAME = "id";

    private $id;
    private $date_inscription;
    private $login;
    private $md5_password;
    private $nom;
    private $prenom;
    private $email;

    public function __construc(string $date_inscription, string $login, string $md5_password, 
                                string $nom, string $prenom, string $email){

                                    if (preg_match('/'+'^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/', $date_inscription)) {

                                        echo 'Cette date est correcte.';
                                        $this->date_inscription=$date_inscription;

                                    } else {

                                        throw new Exception('Date incorrect.');

                                    }

                                    if(preg_match('/'+'^[a-f0-9]{32}$/i', $md5_password)) {

                                        echo "Le format password est valide.";
                                        $this->md5_password=$md5_password;

                                    } else {

                                        throw new Exception('Format Password incorrect.');
                                        
                                    }

                                    if (preg_match('#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i', $email)) {

                                        echo 'Cet email est correct.';
                                        $this->email=$email;

                                    } else {

                                        throw new Exception('Email incorrect.');

                                    }   
                                    
                                    $this->login=$login;
                                    $this->nom=$nom;
                                    $this->prenom=$prenom;
    }
}
