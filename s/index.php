<?php
require("../bootstrap.php");

use SignatureGenerator\SignatureGenerator;
use SignatureGenerator\Storage;

$url = $_SERVER[REQUEST_URI];
$url = explode("/", $url);
$url = $url[count($url) - 1];

if (!ctype_alnum($url)) {
    die("Nice try.");
}
if (file_exists($url)) {
    $data = file_get_contents($url);
    $data = Storage::loadData($data);
    chdir("../");
    $gen = new SignatureGenerator();
    $quotes = $data->quotes;
    $quote = $quotes[array_rand($quotes)];
    $finalLines = array($data->header, $data->subheader, $data->details, $quote);
    $gen->createImage($finalLines)->showToBrowser();
} else {
    die("Not found, sorry");
}