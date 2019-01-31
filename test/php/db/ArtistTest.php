<?php
include "src/models/db/Artist.php";
use PHPUnit\Framework\TestCase;
use src\models\db\Artist;
use src\models\db\Entity;

/**
 * Class ArtistTest
 * Cette classe teste la classe Artist.
 * @coversDefaultClass src\models\db\Artist
 */
final class ArtistTest extends TestCase
{
    private $artist;

    /**
     * @beforeAll
     * @uses Artist
     */
    public function setupNeeds(){
        $this->artist = new Artist("IAM");
    }

    /**
     * @covers Entity::__call
     */
    public function testCall(){
        //Test Get et Set attribut simple
        $this->assertSame(null, $this->artist->getId());
        $this->artist->setId(3);
        $this->assertSame(3, $this->artist->getId());
    }

}