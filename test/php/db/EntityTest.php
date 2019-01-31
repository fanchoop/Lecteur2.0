<?php
include "src/models/db/Entity.php";
use PHPUnit\Framework\TestCase;
use src\models\db\Entity;

/**
 * Class MusicTest
 * Cette classe test la classe Music.
 * @coversDefaultClass src\models\db\Entity
 */
class EntityTest extends TestCase{

    /**
     * Test de la function __constructeur
     * @cover ::__construct
     */
    public function testConstructeur(){
        $this->assertTrue(true);
    }

}