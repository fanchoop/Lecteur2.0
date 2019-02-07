<?php
namespace src\models\db;

use Exception;
use PDO;
use src\models\db\PlaylistMusic;

include_once "src/models/db/Entity.php";
include_once "src/models/db/PlaylistMusic.php";
include_once "src/models/db/DAO.php";

class Playlist extends Entity
{
    const TABLE_NAME = "mp3_playlist";
    const PK_NAME = "id";

    /**
     * Playlist constructor.
     * @param int $id_pers
     * @param string $name
     * @param int|null $id
     */
    public function __construct(int $id_pers, string $name, int $id = null)
    {
        parent::__construct(self::TABLE_NAME, self::PK_NAME);

        $this->hydrate(array(
            "id" => $id,
            "id_pers" => $id_pers,
            "name" => $name
        ));
    }

    /**
     * Fonction d'ajout d'une musique
     * dans la playlist.
     * Manipule un obj PlaylistMusic
     * @param int $idMusic
     * @return bool
     */
    public function addMusic(int $idMusic){
        $playlistMusic = new PlaylistMusic($this->getId(), $idMusic);
        return $playlistMusic->save();
    }

    /**
     * Fonction de suppresion d'une musique
     * dans la playlist.
     * Manipule un obj PlaylistMusic
     * @param int id
     * @return bool
     * @throws Exception
     */
    public function deleteMusic(int $idMusic){
        $playlistMusic = new PlaylistMusic($this->getId(), $idMusic);
        return $playlistMusic->delete();
    }

    /**
     * Fonction pour récuperer toutes
     * les musics de la playlist.
     * Méthode findAll de la classe PlaylistMusic
     * @return array musics
     * @throws Exception
     */
    public function getMusics() : array {
        $playlistMusics = PlaylistMusic::findAll( $this->getId() );
        foreach ($playlistMusics as $playlistMusic){
            $musics[] = Music::find($playlistMusic->getId_fichier());
        }
        return $musics;
    }
}