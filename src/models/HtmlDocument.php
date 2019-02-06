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
        include('src/views/header.html');

        if( $this->mainFilePath != "player" && $this->mainFilePath != "login"){
            //include("src/middleware/checkLogin.php");
            include('src/views/nav.html');

            if($this->mainFilePath == "music"){
                include('src/models/db/Music.php');
            }
            elseif ($this->mainFilePath == "playlist"){
                include('src/models/db/Playlist.php');
            }
            elseif ($this->mainFilePath == "album"){
                include('src/models/db/Album.php');
            }

        }

        $this->parseMain();
        echo $this->mainContent;

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