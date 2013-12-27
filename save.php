<?php
require("bootstrap.php");
use SignatureGenerator\Configuration;
use SignatureGenerator\Storage;
if (Storage::getNumFiles() > Configuration::getMaxFiles()) {
    die("File limit exceeded. Contact the site owner.");
}
$header = $_POST['header'];
$subheader = $_POST['subheader'];
$details = $_POST['details'];
$quotes = $_POST['quotes'];
$quotes = array_map("trim", explode("\n", rtrim($quotes)));
if (trim($header) == "" || trim($subheader) == "" || trim($details) == "") {
    die("You missed a field.");
}
if (strlen($header) > 100 || strlen($details) > 100 || strlen($subheader) > 100 || count($quotes) > 50) {
    die("Too many quotes or too long a line.");
}
foreach ($quotes as $i=>$quote) {
    if ($quote == "" || strlen($quote) > 100) {
        unset($quotes[$i]);
    }
}

if (count($quotes) == 0) {
    die("No valid quotes detected. Quotes must be < 100 characters.");
}

$data = Storage::storeData($header, $subheader, $details, $quotes);
$fn = uniqid();
$fn = "s" . DIRECTORY_SEPARATOR . $fn;
file_put_contents($fn, $data);
die(Configuration::getBaseUrl() . $fn);