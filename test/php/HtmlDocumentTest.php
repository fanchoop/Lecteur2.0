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
    public static function setUpSomeHtml()
    {
        self::$html = new HtmlDocument("res/ctrlTest.php");
        self::$html->addHeader("<link src='test'/>", HtmlDocument::LAST);
    }

    /**
     * @cover ::__construct
     */
    public function testConstruct(){
        $content = self::$html->getMainContent();
        $this->assertSame(null, $content);
    }

    /**
     * @cover ::__construct
     * @cover ::getPath
     * @expectedException Exception
     */
    public function testSingleton(){
        self::$html = new HtmlDocument("res/ctrlTest.php");
    }

    /**
     * @cover ::getCurrentInstance
     */
    public function testGetCurrentInstance(){
        $this->assertEquals(self::$html, HtmlDocument::getCurrentInstance());
    }

    /**
     * @cover ::render
     */
    public function testRender(){
        ob_start();
        self::$html->render();
        $htmlRender = ob_get_contents();
        ob_end_clean();
        $expected = '<div>...</div>';
        $this->assertSame($expected, $htmlRender);
    }

    /**
     * @cover ::parseMain
     * @cover ::getMainContent
     */
    public function testParseMain(){
        self::$html->parseMain();
        $parse = self::$html->getMainContent();
        $this->assertSame("<div>...</div>", $parse);
    }

    /**
     * @cover ::addHeader
     */
    public function testAddHeaderPosFirst(){
        self::$html->addHeader("<link src='firstCSS'/>", HtmlDocument::FIRST);
        $expected = "<link src='firstCSS'/>";
        $this->assertSame(self::$html->getHeader()[0], $expected);
    }

    /**
     * @cover ::addHeader
     * @cover ::getHeader
     */
    public function testAddHeaderPosLast(){
        self::$html->addHeader("<link src='lastCSS'/>", HtmlDocument::LAST);
        $expected = "<link src='lastCSS'/>";
        $this->assertSame(self::$html->getHeader()[2], $expected);
    }


}