<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../include/translation.php';

foreach (glob(__DIR__ . '/../include/classes/*.php') as $filename) {
  require_once $filename;
}

$GLOBALS['protocol'] = 'http';
$GLOBALS['domain'] = 'localhost:8080';
$GLOBALS['language'] = 'sv';
$GLOBALS['supported_languages'] = [
  'en' => 'English',
  'sv' => 'Svenska',
];

$errorHandler = new ErrorHandler();
$errorHandler->register();
