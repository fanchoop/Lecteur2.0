<?php
include "src/models/db/Artist.php";
use PHPUnit\Framework\TestCase;
use src\models\db\Artist;
use src\models\db\DAO;

/**
 * Class ArtistTest
 * Cette classe teste la classe Artist.
 * @coversDefaultClass src\models\db\Artist
 */
final class ArtistTest extends TestCase {
    private $artist;
    private $pdo = null;
    private $conn = null;

    /**
     * @before
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $this->artist = new Artist("IAM");
        $this->assertInstanceOf(Artist::class, $this->artist);
    }

    /**
     * Test getteurs et setteurs de la classe Artiste
     * @covers \src\models\db\Entity::__call
     */
    public function testCall() {
        $this->assertSame("IAM", $this->artist->getNom());
        $this->artist->setNom("NTM");
        $this->assertSame("NTM", $this->artist->getNom());
    }

    /**
     * Test de la fonction findAll de la classe Artist
     * @covers \src\models\db\Artist::findAll
     */
    public function testFindAll() {
        $ARTISTS = Artist::findAll();
        $my_artists = ['VALD', 'SOPRANO', 'BACH', 'MOZART', 'DAVID GUETTA', 'KAZY LAMBIST', 'NIRVANA', 'LED ZEPPELIN', 'METALLICA', 'KATY PERRY', 'RIHANNA'];
        $this->assertSame(11, count($ARTISTS));

        $i = 0;
        foreach ($ARTISTS as $artiste) {
            $this->assertSame($artiste->getNom(), $my_artists[$i]);
            $i++;
        }
    }

    /**
     * Test de la fonction find de la classe Artist
     * @covers \src\models\db\Artist::find
     */
    public function testFind() {
        try{
            $led_zep = Artist::find(8);
        }
        catch (Exception $e){
            $e->getMessage();
        }
        finally{
            DAO::close();
        }

        $this->assertSame($led_zep->getId(), 8);
        $this->assertSame($led_zep->getNom(), 'LED ZEPPELIN');
    }
}