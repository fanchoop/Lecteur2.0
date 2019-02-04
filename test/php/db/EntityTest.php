<?php
include "src/models/db/Music.php";
use PHPUnit\Framework\TestCase;
use src\models\db\Music;

/**
 * Class EntityTest
 * Cette classe test la classe Entity via sa classe enfante Music.
 * @coversDefaultClass src\models\db\Entity
 */
final class EntityTest extends TestCase
{
    private $music;

    /**
     * @before
     */
    public function setupNeeds(){
        $this->music = new Music(1, 1, 1, "J'ai mal au mic", [1, 2, 3, 4, 5], "musique.mp3",
            "pochette.jpg", "Oxmo Puccino", true, 3, 1200, 3, "03/02/2015", 1);
    }

    /**
     * @covers \src\models\db\Entity::__call
     */
    public function testCall(){
        //Test Get et Set attribut simple
        $this->assertSame(1, $this->music->getId());

        $this->music->setId(3);
        $this->assertSame(3, $this->music->getId());

        //Test Get et Set attribut nom complexe
        $this->assertSame([1, 2, 3, 4, 5], $this->music->getListe_point());
        $this->music->setListe_point([1, 2, 3, 4, 5, 6, 7]);
        $this->assertSame( [1, 2, 3, 4, 5, 6, 7] , $this->music->getListe_point() );
    }

    /**
     * @covers \src\models\db\Entity::__call
     */
    public function testCallFalse(){
        //Test Get et Set attribut simple
        $this->assertFalse($this->music->unexistFonctionId());
    }

    /**
     * Test de la méthode hydrate
     * @covers ::hydrate
     * @covers ::getValues
     */
    public function testHydrate(){
        $array = array(
            'id' => 1,
            'id_album' => 1,
            'id_style' => 1,
            'id_profil_artiste' => 1,
            'libelle' => 'J\'ai mal au mic',
            'liste_point' => array(
                0 => 1,
                1 => 2,
                2 => 3,
                3 => 4,
                4 => 5
            ),
            'chemin_mp3' => 'musique.mp3',
            'chemin_pochette' => 'pochette.jpg',
            'artiste_original' => 'Oxmo Puccino',
            'composition' => true,
            'taille' => 3,
            'duree' => "1200",
            'nb_ecoutes' => 3,
            'date_insertion' => '03/02/2015'
        );
        $this->assertSame($array, $this->music->getValues());
    }

    /**
     * Test de la function save
     * @covers
     */
}