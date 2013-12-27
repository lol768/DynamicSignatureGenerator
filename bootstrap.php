<?php
if (!extension_loaded("gd")) {
    die("You must have the gd extension installed.");
}

function __autoload($class) {
    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    require "src" . DIRECTORY_SEPARATOR . $class . '.php';
}