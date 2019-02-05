<?php

include_once "src/models/db/Playlist.php";
use \PHPUnit\Framework\TestCase;
use \src\models\db\Playlist;

/**
 * Class PlaylistTest
 * Cette classe teste la classe Playlist
 * @coversDefaultClass src\models\db\Playlist
 */
final class PlaylistTest extends TestCase {

    private $playlist;

    /**
     * @before
     * @covers ::__construct
     */
    public function testConstruct() {

        $this->playlist = new Playlist(5, "Mon incroyable playlist", 2);
        $this->assertInstanceOf(Playlist::class, $this->playlist);
    }

    /**
     * @covers ::addMusic
     */
    public function testAddMusic() {
        $this->assertTrue($this->playlist->addMusic(1));
    }

    /**
     * @covers ::getMusics
     */
    public function testGetMusics() {

        $libelleMusicExcepted = "Eurotrap";

        $musics = $this->playlist->getMusics();
        foreach ($musics as $music) {
            $this->assertEquals($libelleMusicExcepted, $music->getLibelle());
        }
    }

    /**
     * @covers ::deleteMusic
     */
    public function testDeleteMusic() {
        $this->assertTrue($this->playlist->deleteMusic(1));
    }
}