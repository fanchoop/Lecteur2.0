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

        $this->playlist = new Playlist(5, "Mon incroyable playlist");
        $this->assertInstanceOf(Playlist::class, $this->playlist);
    }

    /**
     * @covers \src\models\db\Playlist::addMusic
     */
//    public function testAddMusic() {
//        $this->assertTrue($this->playlist->save());
//    }

    /**
     * @covers \src\models\db\Playlist::deleteMusic
     */
//    public function testDeleteMusic() {
//
//    }

    /**
     * @covers \src\models\db\Playlist::getMusics
     */
//    public function getMusics() {
//
//    }
}