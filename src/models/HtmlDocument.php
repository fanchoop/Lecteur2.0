<?php

namespace src\models;

use PHPUnit\Runner\Exception;

/**
 * Class HtmlDocument
 * Cette class génére un code HTML.
 */
class HtmlDocument
{
    protected $mainFilePath;
    protected $headers;
    protected $footers;
    protected $script;
    protected $mainContent;
    protected $bodyContent;
    private static $currentInstance;
    const FIRST = 0;
    const LAST = 1;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(string $fileName)
    {
        //Singleton
        if( isset(self::$currentInstance) ){
            throw new Exception("HtmlDocument déjà instancié");
        }

        $this->mainFilePath = $fileName;
        $this->headers = [];
        $this->footers = [];
        $this->script = ["\nvar sP = new SuperPlayer(document.querySelector('div.audioplayer-mini'));\nsP.addMusicObject(music1);\nsP.addMusicObject(music1);\nsP.addMusicObject(music1);"];
        $this->mainContent = null;
        $this->bodyContent = null;

        self::$currentInstance = $this;
    }

    public function parseMain()
    {
        $this->mainFilePath = $this->getPath();
        ob_start();
        include ($this->mainFilePath);
        $this->mainContent = ob_get_contents();
        ob_end_clean();
    }

    public function render()
    {
        echo "<!DOCTYPE html>\n";
        echo "<html lang=\"fr\">\n";
        echo "  <head>\n";
        foreach ($this->headers as $header){
            echo $header;
        }
        echo "  </head>\n";
        echo "  <body>\n";
        $this->parseMain();
        echo $this->mainContent;
        echo "       <div class=\"audioplayer-mini\"></div>\n";
        foreach ($this->footers as $footer){
            echo $footer;
        }
        echo "<script>\n";
        foreach ($this->script as $lineScript){
            echo $lineScript;
        }
        echo "</script>\n";
        echo "</body>\n";
        echo "</html>\n";
    }

    public function addHeader(string $html, int $position)
    {
        if($position === self::LAST){
            array_push($this->headers, $html);
        }
        elseif ($position === self::FIRST){
            array_unshift($this->headers, $html);
        }
    }

    public function addFooter(string $html, int $position)
    {
        if($position === self::LAST){
            array_push($this->footers, $html);
        }
        elseif ($position === self::FIRST){
            array_unshift($this->footers, $html);
        }
    }

    public function addScript(string $html, int $position)
    {
        if($position === self::LAST){
            array_push($this->script, $html);
        }
        elseif ($position === self::FIRST){
            array_unshift($this->script, $html);
        }
    }

    public function getHeader() : array {
        return $this->headers;
    }

    public function getMainContent()
    {
        return $this->mainContent;
    }

    public static function getCurrentInstance() : HtmlDocument
    {
        return self::$currentInstance;
    }

    /**
     * @codeCoverageIgnore
     */
    private function getPath() : string
    {
        $posCtrl = strpos($this->mainFilePath, "ctrl");
        if($posCtrl === false){
            return "src/controllers/ctrl".ucfirst($this->mainFilePath).".php";
        }
        else{
            return $this->mainFilePath;
        }

    }
}