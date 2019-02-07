<?php
include("src/models/Audio.php");

use PHPUnit\Framework\TestCase;
use src\models\Audio;

final class AudioTest extends TestCase {

    /**
     * Fonction de test de la class duration
     */
    public function testGetDurationNormal () {
        $this->assertEquals(19,Audio::getDuration('res/pipeau-Defakator.mp3'));
    }

    public function testGetDurationNoFile () {
        $this->assertEquals(0,Audio::getDuration('NoFileIsNamedLikeThis'));
    }

    public function testGetDurationNotAMP3File () {
        exec('echo "000" > musiquetest.txt');
        $this->assertEquals(0, Audio::getDuration('musiquetest.txt'));
        exec('rm musiquetest.txt');
    }

    public function testReadFirstLineNormal () {
        exec('echo "000" > musiquetest.txt');
        $this->assertEquals("000\n", Audio::readFirstLine('musiquetest.txt'));
        exec('rm musiquetest.txt');
    }

    /**
     * @expectedException Exception
     */
    public function testReadFirstLineNoFile () {
        Audio::readFirstLine('NoFileIsNamedLikeThis');
    }


    public function testPgcdAAndBEquals () {
        $this->assertEquals(1, Audio::pgcd(1, 1));
    }

    public function testPgcdOddAndEvenNumbersWithEvenBigger () {
        $this->assertEquals(7, Audio::pgcd(21, 56));
    }

    public function testPgcdOddAndEvenNumbersWithOddBigger () {
        $this->assertEquals(7, Audio::pgcd(63, 28));
    }

    public function testPgcdEvenNumbers () {
        $this->assertEquals(2, Audio::pgcd(28, 94));
    }

    public function testPgcdOddNumbers () {
        $this->assertEquals(7, Audio::pgcd(35, 91));
    }

    public function testPgcdWithANullNumber () {
        $this->assertEquals(7, Audio::pgcd(0, 7));
        $this->assertEquals(8, Audio::pgcd(0, 8));
    }

    public function testPgcdWithANegativeNumber () {
        $this->assertEquals(8, Audio::pgcd(-32, 8));
        $this->assertEquals(8, Audio::pgcd(8, -32));
    }


    public function testGetFileContentNormal () {
        $f = fopen('test.json', 'w');
        fwrite($f, '{"version":2,"length":10,"data":[-7,7,-10,-1,-4,6,-2,9,-3,3,1,6,-9,7,-9,-2,-2,8,-1,7]}');
        fclose($f);
        $this->assertEquals(10, Audio::getFileContent('test.json')->{'length'});
        $this->assertEquals(2, Audio::getFileContent('test.json')->{'version'});
        $this->assertEquals([-7,7,-10,-1,-4,6,-2,9,-3,3,1,6,-9,7,-9,-2,-2,8,-1,7], Audio::getFileContent('test.json')->{'data'});
    }

    /**
     * @expectedException Exception
     */
    public function testGetFileContentNoFile () {
        Audio::getFileContent('NoFileIsNamedLikeThis');
    }


    public function testRemoveNegativeValueNormal () {
        $this->assertEquals([7,-1,6,9,3,6,7,-2,8,7], Audio::removeNegativeValue(Audio::getFileContent('test.json')));
    }

    /**
     * @expectedException Exception
     */
    public function testRemoveNegativeValueNoDataIndex () {
        $f = fopen('test.json', 'w');
        fwrite($f, '{"version":2,"length":10,"notdata":[-7,7,-10,-1,-4,6,-2,9,-3,3,1,6,-9,7,-9,-2,-2,8,-1,7]}');
        fclose($f);
        Audio::removeNegativeValue(Audio::getFileContent('test.json'));
    }

    /**
     * @expectedException Exception
     */
    public function testRemoveNegativeValueNotAJson () {
        $notAJson = "Definetely not a Json content";
        Audio::removeNegativeValue($notAJson);
    }

    public function testRemoveNegativeValueOddNumberOfValue () {
        $f = fopen('test.json', 'w');
        fwrite($f, '{"version":2,"length":10,"data":[-7,7,-10,-1,-4,6,-2,9,-3,3,1,6,-9,7,-9,-2,-2,8,-1]}');
        fclose($f);
        $this->assertEquals([7,-1,6,9,3,6,7,-2,8], Audio::removeNegativeValue(Audio::getFileContent('test.json')));
    }
}