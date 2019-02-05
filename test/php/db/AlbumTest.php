<?php
include_once "src/models/db/Album.php";
use PHPUnit\Framework\TestCase;
use src\models\db\Album;

/**
 * Class AlbumTest
 * @coversDefaultClass src\models\db\Album
 */
final class AlbumTest extends TestCase
{
    private $album;

    /**
     * @before
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $this->album = new Album(1, "Agartha", "2017-01-01", 1);
        $this->assertInstanceOf(Album::class, $this->album);
    }

    /**
     * @covers ::find
     */
    public function testFind(){
        $album = Album::find(1);
        $this->assertEquals($this->album, $album);
    }

    /**
     * @covers ::findAll
     */
    public function testFindAll(){
        $albums = Album::findAll(1);
        $i = 0;
        $expected = ["Agartha", "On You", "Kickass Metal"];
        foreach ($albums as $album){
            $this->assertEquals($expected[$i], $album->getTitre());
            $i++;
        }
    }
}