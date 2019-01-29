<?php
include "src/models/Music.php";
use PHPUnit\Framework\TestCase;
use src\models\Music;

/**
 * Class MusicTest
 * Cette classe test la classe Music.
 * @coversDefaultClass src\models\Music
 */
final class MusicTest extends TestCase
{
    private $music;

    /**
     * @beforeClass
     */
    public static function setUpNeeds(){

        $music = new Music("J'ai mal au mic","Oxmo Puccino");

    }

    /**
     * @cover ::getId
     */
    public function testGetId(){

        $this->assertSame(0, $music->getId());
        
    }

    /**
     * @cover ::setId
     */
    public function testSetId(){

        $music->setId(42);
        $this->assertSame(42, $music->getId());

    }

    /**
     * @cover ::getTitle
     */
    public function testGetTitle(){

        $this->assertSame("J'ai mal au mic", $music->getTitle());
    }

    /**
     * @cover ::setTitle
     */
    public function testSetTitle(){

        $music->setTitle("Autre titre");
        $this->assertSame("Autre titre", $music->getTitle());

    }

    /**
     * @cover ::getArtist
     */
    public function testGetArtist(){

        $this->assertSame("Oxmo Puccino", $music->getArtist());
    }

    /**
     * @cover ::setArtist
     */
    public function testSetArtist(){

        $music->setArtist("Autre artiste");
        $this->assertSame("Autre artiste", $music->getArtist());

    }
    
}