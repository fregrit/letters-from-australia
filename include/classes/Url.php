<?php

class Url
{
  private string $protocol;
  private string $domain;
  private string $language;

  public const NO_LANG_FOR_PATHS = [
    'letters',
    'images',
    'css',
    'js',
    'fonts',
    'favicon.ico',
  ];

  public function __construct()
  {
    $this->protocol = $GLOBALS['protocol'] ?? 'http';
    $this->domain = $GLOBALS['domain'] ?? 'localhost';
    $this->language = $GLOBALS['language'] ?? 'en';
  }

  public function buildUrl(string $path = '', array $params = []): string
  {
    $url = $this->protocol . '://' . $this->domain . '/';
    if ($this->shouldUseLangPath($path)) {
      $url .= $this->language . '/';
    }
    $url .= ltrim($path, '/');

    if (!empty($params) && is_array($params)) {
      $url .= '?' . http_build_query($params);
    }

    return $url;
  }

  public function getStartpageUrl(): string
  {
    return $this->buildUrl();
  }

  public function getLanguageUrls(string $path = ''): array
  {
    $urls = [];
    
    // Remove the current language prefix from the path, if it exists
    $path = preg_replace("/^\/(en|sv)(\/|$)/", '/', $path);

    foreach ($GLOBALS['supported_languages'] as $langCode => $langName) {
      $url = $this->protocol . '://' . $this->domain . '/' . $langCode . '/' . ltrim($path, '/');
      $urls[$langCode] = $url;
    }

    return $urls;
  }

  private function shouldUseLangPath(string $path = ''): bool
  {
    $pathParts = explode('/', ltrim($path, '/'));
    $firstPathPart = $pathParts[0] ?? '';

    if (stripos($path, 'images/polaroids') === 0 || in_array($firstPathPart, self::NO_LANG_FOR_PATHS)) {
      return false;
    }

    return true;
  }

  public static function getInstance(): Url
  {
    static $instance = null;
    if ($instance === null) {
      $instance = new Url();
    }
    return $instance;
  }
}
