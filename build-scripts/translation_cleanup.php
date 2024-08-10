<?php

require __DIR__ . '/../config/master.php';

function logMessage($message) {
  echo $message . PHP_EOL;
}

function scanForTranslations($directory) {
  $translations = [];

  $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
  foreach ($iterator as $file) {
    if ($file->getExtension() === 'php') {
      $content = file_get_contents($file->getPathname());
      preg_match_all('/translate\(\s*[\'"]([\s\S]*?)[\'"]\s*(,\s*[\'"]([\s\S]*?)[\'"]\s*)?\)/', $content, $matches, PREG_SET_ORDER);
      foreach ($matches as $match) {
        $string = trim(preg_replace('/\s+/', ' ', $match[1])); // Normalize whitespace
        $context = isset($match[3]) ? trim(preg_replace('/\s+/', ' ', $match[3])) : '';
        $translations[$string][$context] = true;
      }
    }
  }

  return $translations;
}

function cleanUpTranslations($filePath, $usedTranslations) {
  if (!file_exists($filePath)) {
    throw new RuntimeException("Translations file not found: $filePath");
  }

  $translations = json_decode(file_get_contents($filePath), true);
  if (json_last_error() !== JSON_ERROR_NONE) {
    throw new RuntimeException("Invalid JSON in translations file");
  }

  $updates = false;
  foreach ($translations as $string => $contexts) {
    foreach ($contexts as $context => $languages) {
      if (!isset($usedTranslations[$string][$context])) {
        unset($translations[$string][$context]);
        $updates = true;
      }
    }
    if (empty($translations[$string])) {
      unset($translations[$string]);
    }
  }

  if ($updates) {
    file_put_contents($filePath, json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    logMessage("Translations file cleaned up successfully.");
  } else {
    logMessage("No unused translations found in the translations file.");
  }
}

try {
  logMessage("Scanning for translations in PHP files...");
  $usedTranslations = scanForTranslations(__DIR__ . '/../');

  logMessage("Cleaning up unused translations...");
  $translationsFilePath = __DIR__ . '/../data/translations.json';
  cleanUpTranslations($translationsFilePath, $usedTranslations);

  logMessage("Translations cleanup completed.");
} catch (Exception $e) {
  logMessage("An error occurred: " . $e->getMessage());
  exit(1);
}

?>
