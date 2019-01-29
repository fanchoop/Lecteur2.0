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
    protected $mainContent;
    protected $bodyContent;
    private static $currentInstance;
    const FIRST = 0;
    const LAST = 1;

    public function __construct(string $fileName)
    {
        //Singleton
        if( isset(self::$currentInstance) ){
            throw new Exception("HtmlDocument déjà instancié");
        }

        $this->mainFilePath = $fileName;
        $this->mainFilePath = $this->getPath();
        $this->headers = [];
        $this->mainContent = null;
        $this->bodyContent = null;

        self::$currentInstance = $this;
    }

    public function parseMain()
    {
        ob_start();
        include ($this->mainFilePath);
        $this->mainContent = ob_get_contents();
        ob_end_clean();
        return $this->mainContent;
    }

    public function render()
    {
        echo $this->parseMain();
    }

    public function addHeader(string $html, int $position)
    {
        if($position === self::FIRST){
            array_push($this->headers, $html);
        }
        elseif ($position === self::LAST){
            array_unshift($this->headers, $html);
        }
    }

    public function getMainContent() : string
    {
        return $this->mainContent;
    }

    public static function getCurrentInstance() : HtmlDocument
    {
        return self::$currentInstance;
    }

    private function getPath() : string
    {
        $posCtrl = strpos($this->mainFilePath, "ctrl");
        if($posCtrl === false){
            return "src/controllers/ctrl".$this->mainFilePath.".php";
        }
        else{
            return $this->mainFilePath;
        }

    }
}