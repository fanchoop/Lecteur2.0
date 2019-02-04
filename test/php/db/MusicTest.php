<?php
include_once "src/models/db/Music.php";
include_once "src/models/db/DAO.php";
use PHPUnit\Framework\TestCase;
use src\models\db\Music;
use src\models\db\DAO;

/**
 * Class MusicTest
 * Cette classe teste la classe Music.
 * @coversDefaultClass src\models\db\Music
 */
final class MusicTest extends TestCase
{
    private $music;

    /**
     * @before
     */
    public function setupNeeds(){
        $this->music = new Music(1, 1, 1, "J'ai mal au mic", [1, 2, 3, 4, 5], "musique.mp3",
            "pochette.jpg", "Oxmo Puccino", true, 3, "1200", 3, "03/02/2015", 1);
    }

    /**
     * Test de la méthode convertJson
     * @covers ::__construct
     */
    public function testConstructeur(){
        $this->assertSame(1, $this->music->getId_album());
    }

    /**
     * Test de la méthode convertJson
     * @covers ::convertJson
     */
    public function testConvertJson(){
        $json = '{"id":1,"id_album":1,"id_style":1,"id_profil_artiste":1,"libelle":"J\'ai mal au mic","liste_point":[1,2,3,4,5],"chemin_mp3":"musique.mp3","chemin_pochette":"pochette.jpg","artiste_original":"Oxmo Puccino","composition":true,"taille":3,"duree":"1200","nb_ecoutes":3,"date_insertion":"03\/02\/2015"}';

        $this->assertSame($json, $this->music->convertJson());
    }

    /**
     * Test de la méthode addListen
     * @covers ::addListen
     */
    public function testAddListen(){
        $nb_ecoutes = $this->music->getNb_ecoutes() +1;
        $this->music->addListen();
        $this->assertSame($nb_ecoutes, $this->music->getNb_ecoutes());
    }

    /**
     * Test de la méthode deleteListen
     * @covers ::deleteListen
     */
    public function testDeleteListen(){
        $nb_ecoutes = $this->music->getNb_ecoutes() -1;
        $this->music->deleteListen();
        $this->assertSame($nb_ecoutes, $this->music->getNb_ecoutes());
    }

    /**
     * Test de la méthide findAll
     * @covers ::findAll

    public function testFindAll(){
        $musics = $this->music->findAll();
    }

    /**
     * Test de la méthode findAll
     * @covers ::findAll
     * @expectedException Exception

    public function testFindAllException(){
        $this->music->findAll();
    }*/

    /**
     * Test de la méthode find
     * @covers ::find
     * @expectedException Exception
     */
    public function testFindException(){
        $this->music->find(1);
    }
}