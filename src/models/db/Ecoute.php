<?php

namespace src\models\db;
include_once "src/models/db/Entity.php";

class Ecoute extends Entity
{

    CONST TABLENAME = 'mp3_ecoutes';
    CONST PKNAME = 'id_fichier, id_pers';

    /**
     * Ecoute constructor.
     * @param int $idMusic
     * @param int $idUser
     * @param string $date
     * @param float $pourcent
     * @param bool $liked
     */
    public function __construct(int $idMusic, int $idUser, string $date, float $pourcent, bool $liked)
    {
        parent::__construct(self::TABLENAME, self::PKNAME);

        $this->hydrate([
            'id_fichier' => $idMusic,
            'id_pers' => $idUser,
            'date_first_ecoute' => $date,
            'pourcent_ecoute' => $pourcent,
            'is_liked' => $liked
        ]);
    }

    /**
     * On recherche dans la base de donnée une ecoute en fonction de l'id de l'utilisateur et de la musique dans la BD.
     * @param $id_user
     * @param $id_music
     * @return Ecoute
     * @throws \Exception
     */
    public static function find($id_user, $id_music): Ecoute
    {
        $pkname[] = explode(", ",self::TABLENAME);

        $connexion = new DAO();

        $sql = "SELECT * FROM " . self::TABLENAME . " WHERE " . $pkname[1] . " = :id_music" . $pkname[2] . " = :id_pers";

        $prepareStatement = $connexion::getInstance()->prepare($sql);
        $prepareStatement->bindValue(":id_pers",$id_user, PDO::PARAM_STR);
        $prepareStatement->bindValue(":id_music",$id_music, PDO::PARAM_STR);
        $prepareStatement->execute();

        $ligne = $prepareStatement->fetch(PDO::FETCH_ASSOC);
        $ecoute = new Ecoute(intVal($ligne['id_fichier']), intVal(ligne['id_pers']), $ligne['date_first_ecoute'], $ligne['pourcent_ecoute'], $ligne['is_liked']);

        $connexion::close();

        return $ecoute;
    }
}