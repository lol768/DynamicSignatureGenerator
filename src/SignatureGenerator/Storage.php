<?php


namespace SignatureGenerator;


use DirectoryIterator;

class Storage {

    public static function storeData($header, $subheader, $details, $quotes) {
        return json_encode(array(
                                "header" => $header,
                                "subheader" => $subheader,
                                "details" => $details,
                                "quotes" => $quotes
                           ));
    }

    public static function loadData($data) {
        return json_decode($data);
    }

    public static function signatureExists($url) {
        if (!ctype_alnum($url)) {
            return false;
        }
        return (file_exists(getcwd() . DIRECTORY_SEPARATOR . "s" . DIRECTORY_SEPARATOR . $url));
    }

    public static function getNumFiles() {
        $dir = new DirectoryIterator(getcwd() . DIRECTORY_SEPARATOR . "s");
        $x = -1; //index
        $x += count($dir);
        return $x;
    }
} 