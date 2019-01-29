<?php

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
        $this->templateName = "default";
        $this->headers = [];
        $this->mainContent = null;
        $this->bodyContent = null;

        self::$currentInstance = $this;
    }

    public function parseMain(){
        ob_start();
        include ("src/controllers/ctrl".$this->mainFilePath.".php");
        $this->mainContent = ob_get_contents();
        ob_end_clean();
    }

    public function render(){
        $this->parseMain();
        echo $this->mainContent;
    }

    public function addHeader(string $html, string $position)
    {

    }

    public function getMainContent() : string
    {
        return "";
    }

    public static function getCurrentInstance() : HtmlDocument
    {
        return self::$currentInstance;
    }
}