<?php
namespace src\models;

use Exception;

class Audio{

    /**
     * Main function
     */
    public static function extractWaveForm($filename) {

        $duration = self::getDuration($filename);
        $stickNumber = 400;
        $pgcdValue = self::pgcd($duration, $stickNumber);

        if ($duration * $pgcdValue < $stickNumber) {
            $pgcdValue = $stickNumber;
        }

        $duration = $duration * $pgcdValue;
        $result = $duration / $stickNumber;
        exec('touch musique.json');
        exec('audiowaveform -i '.$filename.' -o musique.json -b 8 --pixels-per-second '.$pgcdValue);
        $content = self::getFileContent('musique.json');
        $contentPositive = self::removeNegativeValue($content);
        $contentFinal = self::getFinalTab($contentPositive, $result, $stickNumber);
        $content->{'data'} = $contentFinal;
        $f = fopen('musique.json', 'w');
        fwrite($f, '{"duration":'.self::getDuration($filename).',"values":'.json_encode($contentFinal)."}");
        fclose($f);
        exec("rm musique.txt");
    }

    /**
     * This method used to get the duration of the mp3 file
     * that will be treated by the script.
     * @param $filename the name of the mp3 file
     * @return int
     * @throws Exception
     */
    public static function getDuration($filename) : int {
        exec('touch musique.txt');
        exec('mediainfo --Inform="Audio;%Duration%" '.$filename.' > musique.txt');
        $duration = self::readFirstLine('musique.txt');

        if ($duration == '\n') {
            $duration = 0;
        } else {
            $duration = intval(floatval($duration)/1000);
        }

        return $duration;
    }

    /**
     * @param $filename
     * @return string the first line of the param's file
     * @throws Exception
     */
    public static function readFirstLine($filename) : string {
        try {
            $firstLine = '\n';
            if($f = fopen($filename, 'r')){
                $firstLine = fgets($f); // read until first newline
                fclose($f);
            }
        } catch (Exception $e) {
            throw new Exception('No File found with the name '.$filename);
        }
        return $firstLine;
    }

    /**
     * @param $a
     * @param $b
     * @return int
     */
    public static function pgcd($a, $b) {
        $rep = 0;
        if ($b == 0) {
            $rep = $a;
        } else {
            $r = $a%$b;
            $rep = self::pgcd($b, $r);
        }
        return $rep;
    }

    /**
     * @param $filename
     * @return mixed
     * @throws Exception
     */
    public static function getFileContent($filename) {
        try {
            $json = file_get_contents($filename);
            $content = json_decode($json);
            return $content;
        } catch (Exception $e) {
            throw new Exception('No File found with the name '.$filename);
        }
    }

    /**
     * @param $content
     * @return array
     * @throws Exception
     */
    public static function removeNegativeValue ($content) {
        try {
            $content = $content->{'data'};
        } catch (Exception $e) {
            throw new Exception($e);
        }
        $y = 0;
        $contentPositive = [];
        for ($i = 0; $i < count($content); $i++) {
            if ($i%2 != 0) {
                $contentPositive[$y] = $content[$i];
                $y++;
            }
        }
        return $contentPositive;
    }

    /**
     * @param $content
     * @param $result
     * @return array
     */
    public static function getFinalTab ($content, $result, $stickNumber) {
        $finalContent = [] ;
        $n = 0;
        for ($i = 0; $i < $stickNumber; $i++) {
            $average = 0;
            for ($y = 0; $y < $result; $y++) {
                $average = $average + $content[$n];
                $n++;
            }
            $finalContent[$i] = intval($average/$result);
        }
        return $finalContent;
    }
}