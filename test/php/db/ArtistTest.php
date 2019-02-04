<?php
include "src/models/db/Artist.php";
use PHPUnit\Framework\TestCase;
use src\models\db\Artist;

/**
 * Class ArtistTest
 * Cette classe teste la classe Artist.
 * @coversDefaultClass src\models\db\Artist
 */
final class ArtistTest extends TestCase {
    private static $artist;
    private static $pdo = null;
    private static $conn = null;

    /**
     * @beforeClass
     * @uses Artist
     */
    public static function setUpSomeArtist()
    {
        self::$artist = new Artist("IAM");
    }

    /**
     * Test getteurs et setteurs
     * @covers \src\models\db\Entity::__call
     */
    public static function testCall() {
        self::assertSame("IAM", self::$artist->getNom());
        self::$artist->setNom("NTM");
        self::assertSame("NTM", self::$artist->getNom());
    }

    /**
     * @covers \src\models\db\Artist::findAll
     */
    public function testFindAll() {
    }
}