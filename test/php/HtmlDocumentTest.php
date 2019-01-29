<?php
include "src/models/HtmlDocument.php";
use PHPUnit\Framework\TestCase;
use src\models\HtmlDocument;

/**
 * Class HtmlDocumentTest
 * Cette class test la class
 * HtmlDocument.
 * @coversDefaultClass src\models\HtmlDocument
 */
final class HtmlDocumentTest extends TestCase
{
    private static $html;

    /**
     * @beforeClass
     */
    public function instanceHtml()
    {
        self::$html = new HtmlDocument("test/php/ctrlTest.php");
    }

    /**
     * @cover ::__construct
     * @doesNotPerformAssertions
     */
    public function testConstruct(){
        self::$html->render();
    }

    /**
     * @cover ::__construct
     * @expectedException Exception
     */
    public function testSingleton(){
        self::$html = new HtmlDocument("test/php/ctrlTest.php");
    }

    /**
     * @cover ::getCurrentInstance
     */
    public function testGetCurrentInstance(){

        $this->assertEquals(self::$html, HtmlDocument::getCurrentInstance());
    }
}