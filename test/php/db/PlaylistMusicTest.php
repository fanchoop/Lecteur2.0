<?php

include_once "src/models/db/PlaylistMusic.php";
use src\models\db\PlaylistMusic;
use \PHPUnit\Framework\TestCase;

/**
 * User: Leveque Melvin
 * Date: 04/02/19
 * Class PlaylistMusicTest
 * Cette classe test la classe PlaylistMusic.
 * @coversDefaultClass src\models\db\PlaylistMusic
 */
final class PlaylistMusicTest extends TestCase
{
    private $PlaylistMusics;

    /**
     * @before
     */
    public function setupNeeds(){
        $this->PlaylistMusics = new PlaylistMusic(1, 1);
    }

    /**
     * Test du contructeur
     * @covers ::__construct
     */
    public function testConstructeur(){
        $this->assertSame(1, $this->PlaylistMusics->getId_playlist());
    }

    /**
     * Returns the test database connection.
     *
     * @return \PHPUnit\DbUnit\Database\Connection
     */protected function getConnection()
    {
        // TODO: Implement getConnection() method.
    }/**
     * Returns the test dataset.
     *
     * @return \PHPUnit\DbUnit\DataSet\IDataSet
     */protected function getDataSet()
    {
        // TODO: Implement getDataSet() method.
    }
}