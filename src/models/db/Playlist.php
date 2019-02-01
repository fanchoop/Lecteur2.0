<?php
namespace src\models\db;

use Exception;
use PDO;

include_once "src/models/db/Entity.php";
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
        parent::__construct(TABLE_NAME, PK_NAME);

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
     * @param Music $music
     */
    public function addMusic(int $idMusic){
        $playlistMusic = new PlaylistMusic($this->getId(), $idMusic);
        $playlistMusic->save();
    }

    /**
     * Fonction de suppresion d'une musique
     * dans la playlist.
     * Manipule un obj PlaylistMusic
     * @param int id
     * @throws Exception
     */
    public function deleteMusic(int $idMusic){
        $playlistMusic = PlaylistMusic::find($this->getId(), $idMusic);
        $playlistMusic->delete();
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
            $musics[] = Music::find($playlistMusic->getId_fichiers());
        }
        return $musics;
    }
}