<?php
include "src/models/db/DAO.php";
use PHPUnit\Framework\TestCase;
use src\models\db\DAO;

/**
 * Class EntityTest
 * Cette classe test la classe DAO.
 * @coversDefaultClass src\models\db\DAO
 */
 final class DAOTest extends TestCase
{
    private static $DAO;
    const host = "localhost";
    const nameBdd = "lecteur";
    const user = "root";
    const mdp = "";

    /**
     * Test du constructeur de
     * la classe DAO.
     * @beforeClass
     * @covers ::__construct
     */
    public function testConstruct(){
        self::$DAO = new DAO();
        $pdo = new PDO ("mysql:host=" . self::host . ";dbname=" . self::nameBdd.';charset=utf8', self::user, self::mdp);
        $this->assertEquals($pdo, DAO::getInstance());
    }

     /**
      * Test du constructeur de
      * la classe DAO.
      * @covers ::getInstance
      */
     public function testGetInstance(){
         $this->assertInstanceOf(PDO::class, DAO::getInstance());
     }

     /**
      * Test du singleton
      * @covers ::__construct
      * @expectedException Exception
      */
     public function testSingletonException(){
         self::$DAO = new DAO();
     }

     /**
      * Test de la méthode close
      * @covers ::close
      */
     public function testClose(){
         DAO::close();
         $this->assertEquals(null, DAO::getInstance());
     }
}