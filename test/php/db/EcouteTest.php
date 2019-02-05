<?php

include_once "src/models/db/Ecoute.php";
use PHPUnit\Framework\TestCase;
use src\models\db\Ecoute;

/**
 * Class EcouteTest
 * @coversDefaultClass \src\models\db\Ecoute
 */
final class EcouteTest extends TestCase {

    private $ecoute;

    /**
     * Test du constructeur
     * @covers ::__construct
     * @before
     */
    public function testConstruct(){

        $this->ecoute = new Ecoute(1, 1, "2019-01-30 11:35:36", 0.55, false);
        $this->assertInstanceOf(Ecoute::class, $this->ecoute);
    }

    /**
     * Test de la méthode find
     * @covers ::find
     */
    public function testFind(){
        try{
            $ecoute = Ecoute::find(1, 1);
        }
        catch (Exception $e) {
            $e->getMessage();
            $ecoute = null;
        }

        $this->assertEquals($ecoute, $this->ecoute);
    }
}