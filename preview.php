<?php
require("bootstrap.php");
use SignatureGenerator\SignatureGenerator;

$header = $_GET['h'];
$subHeader = $_GET['s'];
$details = $_GET['d'];
$quote = $_GET['q'];
$generator = new SignatureGenerator();
$generator->createImage(array($header, $subHeader, $details, $quote))->showToBrowser();