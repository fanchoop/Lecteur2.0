<?php
include_once "src/models/db/Music.php";
use PHPUnit\Framework\TestCase;
use src\models\db\Music;

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
            "pochette.jpg", "Oxmo Puccino", true, 3, 1200, 3, "03/02/2015", 1);
    }

    /**
     * Test de la méthode convertJson
     */
    public function testConvertJson(){
        $json = '{"id_Album":1,"id_style":1,"id_profil_artiste":1,"libelle":"J\'ai mal au mic","liste_point":[1,2,3,4,5],"chemin_mp3":"musique.mp3","chemin_pochette":"pochette.jpg","artiste_original":"Oxmo Puccino","composition":true,"taille":3,"duree":1200,"nb_ecoutes":3,"date_insertion":"03\/02\/2015","id":1}';

        $this->assertSame($json, $this->music->convertJson());
    }

}