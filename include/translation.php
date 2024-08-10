<?php
function translate($string, $context = '')
{
  global $logger;

  // Ensure the current language is set in the global scope
  $currentLanguage = isset($GLOBALS['language']) ? $GLOBALS['language'] : 'en';

  // If the language is English, return the original string
  if ($currentLanguage === 'en') {
    return $string;
  }

  // Normalize the input string and context
  $string = trim(preg_replace('/\s+/', ' ', $string)); // Normalize whitespace
  $context = trim(preg_replace('/\s+/', ' ', $context)); // Normalize context whitespace

  $translationsFile = __DIR__ . '/../data/translations.json';

  // Check if the translations file exists and load it
  if (!file_exists($translationsFile)) {
    $initialData = json_encode(new stdClass(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents($translationsFile, $initialData);
    $translations = [];
  } else {
    $translations = json_decode(file_get_contents($translationsFile), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
      $logger->error("Invalid JSON in translations file");
      return $string;
    }
  }

  // Check if the string and context exist in the translations
  if (!isset($translations[$string]) || !isset($translations[$string][$context])) {
    // Initialize the structure if it doesn't exist
    $translations[$string][$context] = [
      'sv' => ''
    ];

    // Write the updated translations back to the file
    file_put_contents($translationsFile, json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
  }

  // Return the translated string if it exists, otherwise return the original string
  return !empty($translations[$string][$context][$currentLanguage]) 
    ? $translations[$string][$context][$currentLanguage] 
    : $string;
}
