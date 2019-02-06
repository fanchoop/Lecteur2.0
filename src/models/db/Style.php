<?php

namespace src\models\db;

use Exception;
use PDO;

include_once "src/models/db/Entity.php";
include_once "src/models/db/DAO.php";

/**
 * Class Style
 * @package src\models\db
 *
 */
class Style extends Entity {

    const TABLE_NAME = "mp3_styles";
    const PK_NAME = "id";

    /**
     * Style constructor.
     * @param string $libelle
     * @param int|null $id
     */
    public function __construct(string $libelle, int $id = null) {

        parent::__construct(self::TABLE_NAME, self::PK_NAME);
        $this->hydrate(array(
            'id' => $id,
            'libelle' =>  $libelle
        ));
    }

    /**
     * Cette méthode retourne tous les styles de musiques dans la base de données.
     * @return array
     * @throws Exception
     */
    public static function findAll() : array {
        $styles = array();
        $connexion = new DAO();
        $sql = "SELECT * FROM ".self::TABLE_NAME.";";
        $pst = $connexion::getInstance()->prepare($sql);
        $pst->execute();
        $ligne = $pst->fetch(PDO::FETCH_ASSOC);

        while ($ligne) {
            $style = new Style(
                strval($ligne['libelle']), intval($ligne['id'])
            );

            $styles[] = $style;
            $ligne = $pst->fetch(PDO::FETCH_ASSOC);
        }
        $connexion::close();
        return $styles;
    }

    /**
     * Cette méthode retourne un style de musique en particulier en fonction d'un identifiant.
     * @param $id
     * @return Style
     * @throws Exception
     */
    public static function find($id) : Style {
        $style = null;

        $connexion = new DAO();
        $sql = "SELECT * FROM ".self::TABLE_NAME." WHERE ".self::PK_NAME." = :id;";

        $pst = $connexion::getInstance()->prepare($sql);
        $pst->bindValue(":id",$id, PDO::PARAM_INT);

        $result = $pst->execute();
        if ($result) {
            $ligne = $pst->fetch(PDO::FETCH_ASSOC);

            $style = new Style(
              strval($ligne['libelle']), intval($ligne['id'])
            );
        }

        DAO::close();
        return $style;
    }

}