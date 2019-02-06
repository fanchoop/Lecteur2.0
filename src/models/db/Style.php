<?php

namespace src\models\db;
include_once "src/models/db/Entity.php";

use PDO;

/**
 * Class Style
 * @package src\models\db
 */
class Style extends Entity {

    CONST TABLENAME = 'mp3_styles';
    CONST PKNAME = 'id';

    /**
     * Constructeur de l'objet Style, qui prend en paramètre le nom d'un genre.
     * Paramètre optionnel : identifiant du genre musicale
     * @param string $nomGenreMusical
     * @param int|null $id
     */
    public function __construct(string $nomGenreMusical, int $id = null) {
        parent::__construct(self::TABLENAME, self::PKNAME);

        $this->hydrate(array(
           'id' => $id,
           'libelle' => $nomGenreMusical
        ));
    }

    public function findAll() : array {
        $connexion = new DAO();
        $sql = "SELECT * FROM ".self::TABLENAME;
        $prepareStatement = $connexion::getInstance()->prepare($sql);
        $toto = $prepareStatement->execute();
        var_dump($toto);
        $ligne = $prepareStatement->fetch(PDO::FETCH_ASSOC);

        while ($ligne) {
            $style = new Style(str($ligne['libelle']), intVal($ligne['id']));

            $styles[] = $style;

            $ligne = $prepareStatement->fetch(PDO::FETCH_ASSOC);
        }
        $connexion::close();
        return $styles;
    }

    public function find(int $id_style) : Style {
        $connexion = new DAO();

        $sql = "SELECT * FROM ".self::TABLENAME." WHERE ".self::PKNAME." = :id_style";

        $prepareStatement = $connexion::getInstance()->prepare($sql);
        $prepareStatement->bindValue(":id_style",$id_style, PDO::PARAM_INT);

        $prepareStatement->execute();
        $ligne = $prepareStatement->fetch(PDO::FETCH_ASSOC);

        $style = new Style($ligne['libelle'], intval($ligne['id']));

        $connexion::close();

        return $style;
    }
}