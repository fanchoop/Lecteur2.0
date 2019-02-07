<?php

namespace src\models\db;

use Exception;
use PDO;

include_once "src/models/db/Entity.php";
include_once "src/models/db/DAO.php";
include_once "src/models/db/Music.php";
include_once "src/models/db/Playlist.php";

class PlaylistMusic extends Entity
{
    const TABLE_NAME = "mp3_playlist_fichiers";
    const PK_NAME = "id_playlist, id_fichier";

    /**
     * PlaylistMusic constructor.
     * @param int $id_playlist
     * @param int $id_fichier
     */
    public function __construct(int $id_playlist, int $id_fichier)
    {
        parent::__construct(self::TABLE_NAME, self::PK_NAME);

        $this->hydrate(array(
            "id_playlist" => $id_playlist,
            "id_fichier" => $id_fichier
        ));
    }

    /**
     * @param $id_playlist
     * @return array
     * @throws Exception
     */
    public static function findAll($id_playlist) : array{
        $connexion = new DAO();

        $sql = "SELECT * FROM ".self::TABLE_NAME." WHERE id_playlist = :id_playlist";

        $prepareStatement = $connexion::getInstance()->prepare($sql);
        $prepareStatement->bindValue(":id_playlist", $id_playlist, PDO::PARAM_INT);

        $prepareStatement->execute();
        $ligne = $prepareStatement->fetch(PDO::FETCH_ASSOC);

        while ($ligne) {
            $playlistMusics[] = new PlaylistMusic($ligne["id_playlist"], $ligne["id_fichier"]);

            $ligne = $prepareStatement->fetch(PDO::FETCH_ASSOC);
        }
        $connexion::close();
        return $playlistMusics;
    }
}