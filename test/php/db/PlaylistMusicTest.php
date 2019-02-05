<?php

include_once "src/models/db/PlaylistMusic.php";
use src\models\db\PlaylistMusic;
use src\models\db\DAO;
use \PHPUnit\Framework\TestCase;

/**
 * User: Leveque Melvin
 * Date: 04/02/19
 * Class PlaylistMusicTest
 * Cette classe test la classe PlaylistMusic.
 * @coversDefaultClass src\models\db\PlaylistMusic
 */
final class PlaylistMusicTest extends TestCase
{
    private $PlaylistMusics;

    /**
     * @before
     * @covers ::__construct
     */
    public function testConstructeur(){
        $this->PlaylistMusics = new PlaylistMusic(1, 1);
        $this->assertInstanceOf(PlaylistMusic::class, $this->PlaylistMusics);
    }

    /**
     * @covers ::findAll
     */
    public function testFindAll(){
        DAO::close();

        try{
            $playlistMusics = PlaylistMusic::findAll(1);
        }
        catch(Exception $e){
            echo $e->getMessage();
            $playlistMusics = null;
        }
        finally{
            DAO::close();
        }


        $idMusics = [1, 2, 3];
        $this->assertSame(3, count($playlistMusics));

        $i = 0;
        foreach ($playlistMusics as $playlistMusic) {
            $this->assertSame($playlistMusic->getId_fichiers(), $idMusics[$i]);
            $i++;
        }
    }
}