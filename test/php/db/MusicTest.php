<?php
include "src/models/db/Music.php";
use PHPUnit\Framework\TestCase;
use src\models\db\Music;
use src\models\db\Entity;

/**
 * Class MusicTest
 * Cette classe test la classe Music.
 * @coversDefaultClass src\models\db\Music
 */
final class MusicTest extends TestCase
{
    private $music;

    /**
     * @beforeAll
     * @uses Music
     */
    public function setupNeeds(){
        $this->music = new Music(1, 1, 1, "J'ai mal au mic", [1, 2, 3, 4, 5], "musique.mp3",
            "pochette.jpg", "Oxmo Puccino", true, 3, 20, "03/02/2015");
    }

    /**
     * @covers Entity::__call
     */
    public function testCall(){
        //Test Get et Set attribut simple
        $this->assertSame(null, $this->music->getId());
        $this->music->setId(3);
        $this->assertSame(3, $this->music->getId());

        //Test Get et Set attribut nom complexe
        $this->assertSame([1, 2, 3, 4, 5], $this->music->getListe_point());
        $this->music->setListe_point([1, 2, 3, 4, 5, 6, 7]);
        $this->assertSame( [1, 2, 3, 4, 5, 6, 7] , $this->music->getListe_point() );
    }

}