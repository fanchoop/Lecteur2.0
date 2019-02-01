<?php
include "src/models/db/Artist.php";
use PHPUnit\Framework\TestCase;
use src\models\db\Artist;

/**
 * Class ArtistTest
 * Cette classe teste la classe Artist.
 * @coversDefaultClass src\models\db\Artist
 */
final class ArtistTest extends TestCase
{
    private $artist;

    /**
     * @before
     * @uses Artist
     */
    public function setupNeeds(){
        $this->artist = new Artist("IAM");
    }

    /**
     * Test getteurs et setteurs
     * @covers \src\models\db\Entity::__call
     */
    public function testCall(){
        $this->assertSame("IAM", $this->artist->getNom());
        $this->artist->setNom("NTM");
        $this->assertSame("NTM", $this->artist->getNom());
    }
}