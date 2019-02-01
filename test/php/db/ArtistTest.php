<?php
include "src/models/db/Artist.php";
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use src\models\db\Artist;

/**
 * Class ArtistTest
 * Cette classe teste la classe Artist.
 * @coversDefaultClass src\models\db\Artist
 */
final class ArtistTest extends TestCase
{
    private $artist;
    private $pdo = null;
    private $conn = null;

    use TestCaseTrait;

    public function setUp()
    {
//        $this->artist = new Artist("toto");
    }

    public function tearDown()
    {

    }

    /**
     * @return PHPUnit\DbUnit\Database\Connection
     */
    public function getConnection()
    {
        if ($this->conn === null) {
            if ($this->pdo == null) {
                $this->pdo = new PDO('mysql:dbname=lecteur_test;host=localhost', 'user', 'user');
            }
            $this->conn = $this->createDefaultDBConnection($this->pdo,'leteur-test');
        }
        return $this->conn;
    }

    /**
     * @return PHPUnit\DbUnit\DataSet\IDataSet
     */
    public function getDataSet() {
        return $this->createFlatXMLDataSet('test/php/res/database.xml');
    }

    /**
     * @before
     * @uses Artist
     */
    public function setupNeeds() {
        $this->artist = new Artist("IAM");
    }

    /**
     * Test getteurs et setteurs
     * @covers \src\models\db\Entity::__call
     */
    public function testCall() {
        $this->assertSame("IAM", $this->artist->getNom());
        $this->artist->setNom("NTM");
        $this->assertSame("NTM", $this->artist->getNom());
    }

    /**
     * @covers \src\models\db\Artist::findAll
     */
    public function testFindAll() {
        $this->getConnection()->createDataSet(array('profil_profils_artistes'));
        $artistes = $this->getDataSet();
        $queryTable = $this->getConnection()->createQueryTable('profil_profils_artistes','SELECT * FROM profil_profils_artistes');
        $expectedTable = $this->getDataSet()->getTable('profil_profils_artistes');
        $this->assertTablesEqual($expectedTable,$queryTable);
    }
}