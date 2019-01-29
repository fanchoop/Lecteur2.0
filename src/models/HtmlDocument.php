<?php

namespace src\models;

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
            throw new \http\Exception\BadMethodCallException("HtmlDocument déjà instancié");
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
    }

    public function render()
    {
        $this->parseMain();
        echo $this->mainContent;
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
        if(!$posCtrl){
            return $this->mainFilePath;
        }
        else{
            return "src/controllers/ctrl".$this->mainFilePath.".php";
        }

    }
}