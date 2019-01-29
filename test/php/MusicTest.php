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

    /**
     * @cover ::getGenre
     */
    public function testGetGenre(){

        $this->assertSame([], self::$music->getGenre());
    }

    /**
     * @cover ::setGenre
     */
    public function testSetGenre(){

        self::$music->setGenre("newGenre");
        $this->assertSame(["newGenre"], self::$music->getGenre());

    }

    /**
     * @cover ::getAnnee
     */
    public function testGetAnnee(){

        $this->assertSame(0, self::$music->getAnnee());
    }

    /**
     * @cover ::setAnnee
     */
    public function testSetAnnee(){

        self::$music->setAnnee(1990);
        $this->assertSame(1990, self::$music->getAnnee());

    }

    /**
     * @cover ::getLike
     */
    public function testGetLike(){

        $this->assertSame(0, self::$music->getLike());
    }

    /**
     * @cover ::setLike
     */
    public function testSetLike(){

        self::$music->setLike(42);
        $this->assertSame(42, self::$music->getLike());

    }

    /**
     * @cover ::addLike
     */
    public function testAddLike(){

        self::$music->addLike();
        $this->assertSame(43, self::$music->getLike());

    }

    /**
     * @cover ::deleteLike
     */
    public function testDeleteLike(){

        self::$music->deleteLike();
        $this->assertSame(42, self::$music->getLike());

    }

    /**
     * @cover ::getView
     */
    public function testGetView(){

        $this->assertSame(0, self::$music->getView());
    }

    /**
     * @cover ::setView
     */
    public function testSetView(){

        self::$music->setView(42);
        $this->assertSame(42, self::$music->getView());

    }

    /**
     * @cover ::addView
     */
    public function testAddView(){

        self::$music->addView();
        $this->assertSame(43, self::$music->getView());

    }
}