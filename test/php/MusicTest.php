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
    private static $music;

    /**
     * @beforeClass
     */
    public static function setUpNeeds(){

        self::$music = new Music("J'ai mal au mic","Oxmo Puccino");

    }

    /**
     * @cover ::getId
     */
    public function testGetId(){

        $this->assertSame(0, self::$music->getId());
        
    }

    /**
     * @cover ::setId
     */
    public function testSetId(){

        self::$music->setId(42);
        $this->assertSame(42, self::$music->getId());

    }

    /**
     * @cover ::getTitle
     */
    public function testGetTitle(){

        $this->assertSame("J'ai mal au mic", self::$music->getTitle());
    }

    /**
     * @cover ::setTitle
     */
    public function testSetTitle(){

        self::$music->setTitle("Autre titre");
        $this->assertSame("Autre titre", self::$music->getTitle());

    }

    /**
     * @cover ::getArtist
     */
    public function testGetArtist(){

        $this->assertSame("Oxmo Puccino", self::$music->getArtist());
    }

    /**
     * @cover ::setArtist
     */
    public function testSetArtist(){

        self::$music->setArtist("Autre artiste");
        $this->assertSame("Autre artiste", self::$music->getArtist());

    }
    
}