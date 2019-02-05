<?php
include "src/models/db/Style.php";
use PHPUnit\Framework\TestCase;
use src\models\db\Style;
use src\models\db\DAO;

/**
 * Class StyleTest
 * Cette classe teste la classe Style.
 * @coversDefaultClass src\models\db\Style
 */
final class StyleTest extends TestCase {
    private $style;

    /**
     * @before
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $this->style = new Style("Reggae");
        $this->assertInstanceOf(Style::class, $this->style);
    }

    /**
     * Test getteurs et setteurs de la classe Style
     * @covers \src\models\db\Entity::__call
     */
    public function testCall() {
        $this->assertSame("Reggae", $this->style->getLibelle());
        $this->style->setLibelle("Dubstep");
        $this->assertSame("Dubstep", $this->style->getLibelle());
    }

    /**
     * Test de la fonction findAll de la classe Style
     * @covers ::findAll
     */
    public function testFindAll() {
        try{
            $styles = Style::findAll();
        }
        catch (Exception $e){
            $e->getMessage();
        }
        finally{
            DAO::close();
        }

        $my_styles = ['ROCK', 'POP', 'ELECTRO', 'RAP', 'CLASSIQUE'];
        $this->assertSame(5, count($styles));

        $i = 0;
        foreach ($styles as $style) {
            $this->assertSame($style->getLibelle(), $my_styles[$i]);
            $i++;
        }
    }

    /**
     * Test de la fonction find de la classe Style
     * @covers ::find
     */
    public function testFind() {
        try{
            $rock = Style::find(1);
            $electro = Style::find(3);
            $classique = Style::find(5);
        }
        catch (Exception $e){
            $e->getMessage();
        }
        finally{
            DAO::close();
        }

        // ROCK
        $this->assertSame($rock->getId(), 1);
        $this->assertSame($rock->getLibelle(), 'ROCK');

        // ELECTRO
        $this->assertSame($electro->getId(), 3);
        $this->assertSame($electro->getLibelle(), 'ELECTRO');

        // CLASSIQUE
        $this->assertSame($classique->getId(), 5);
        $this->assertSame($classique->getLibelle(), 'CLASSIQUE');
    }
}