<?php
include_once "src/models/db/Style.php";
include_once "src/models/db/DAO.php";
use PHPUnit\Framework\TestCase;
use src\models\db\Style;
use src\models\db\DAO;

/**
 * Class StyleTest
 * Cette classe teste la classe Style
 * @coversDefaultClass src\models\db\Style
 */
final class StyleTest extends TestCase {

    private $style;

    /**
     * @before
     */
    public function setupNeeds() {
        $this->style = new Style('Reggae', 8);

    }

    /**
     * Test du constructeur de la classe Style
     * @cover ::__construct
     */
    public function testConstructeur() {
        $this->assertInstanceOf(Style::class, $this->style);
        $this->assertSame(8, $this->style->getId());
    }

    /**
     * Test de la méthode findAll de Style
     * @covers ::findAll
     */
    public function testFindAll() {
        try {
            $mesStyles = Style::findAll();
        } catch (Exception $e) {
            $e->getMessage();
        } finally {
            DAO::close();
        }

        $nomStyle = ['ROCK','POP','ELECTRO','RAP','CLASSIQUE'];

        $i = 0;
        foreach ($mesStyles as $style) {
            $this->assertSame($style->getLibelle(), $nomStyle[$i]);
            $i++;
        }
    }

    /**
     * Test de la méthode find de Styke
     * @covers ::find
     */
    public function testFind() {
        try {
            $electro = Style::find(3);
        } catch (Exception $e) {
            $e->getMessage();
        } finally {
            DAO::close();
        }
        $this->assertSame($electro->getLibelle(), 'ELECTRO');
        $this->assertSame($electro->getId(), 3);
    }
}