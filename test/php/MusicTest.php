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

    /**
     * @cover ::getPath
     */
    public function testGetId(){

        $music = new Music("J'ai mal au mic","Oxmo Puccino");
        $this->assertSame(0, $music->getId());
    }
}