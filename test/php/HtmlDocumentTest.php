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
    /**
     * @cover ::__construct
     */
    public function testConstruct(){
        $html = new HtmlDocument("test/php/ctrlTest.php");
    }

}