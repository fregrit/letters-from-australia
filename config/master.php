<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../include/translation.php';

foreach (glob(__DIR__ . '/../include/classes/*.php') as $filename) {
  require_once $filename;
}

// Determine the protocol (http or https) based on the environment
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https' : 'http';

// Determine the domain based on the environment
$domain = $_SERVER['HTTP_HOST'] ?? 'localhost:8080';

$GLOBALS['protocol'] = $protocol;
$GLOBALS['domain'] = $domain;
$GLOBALS['language'] = 'sv';
$GLOBALS['supported_languages'] = [
  'en' => 'English',
  'sv' => 'Svenska',
];

$errorHandler = new ErrorHandler();
$errorHandler->register();
