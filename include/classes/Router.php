<?php

class Router
{
  private array $routes = [];
  private Template $template;

  public function __construct()
  {
    $this->template = new Template();
    $this->initializeRoutes();
  }

  private function initializeRoutes(): void
  {
    $supportedLanguages = array_keys($GLOBALS['supported_languages']);
    $languagePattern = implode('|', $supportedLanguages);

    $this->routes = [
      "/^\/($languagePattern)$/" => 'startPage',
      "/^\/($languagePattern)\/letters$/" => 'lettersPage',
      "/^\/($languagePattern)\/(\d{4}-\d{2}-\d{2})$/" => 'letterPage',
      "/^\/($languagePattern)\/website$/" => 'websitePage', // Add route for websitePage
    ];
  }

  public function route(): void
  {
    $uri = $_SERVER['REQUEST_URI'];

    // Remove query string before routing
    $uri = explode('?', $uri)[0];

    // Normalize URI by removing trailing slash (but not if it's just "/")
    $uri = rtrim($uri, '/') ?: '/';

    // Check if the root path is accessed
    if ($uri === '/') {
      // Redirect to the default language (Swedish in this case)
      $this->redirectToDefaultLanguage();
      return;
    }

    // Bypass routing for static files
    if ($this->isStaticFileRequest($uri)) {
      return; // Let Apache serve the static file
    }

    foreach ($this->routes as $pattern => $method) {
      if (preg_match($pattern, $uri, $matches)) {
        $language = $matches[1];
        $param = $matches[2] ?? null;

        $this->setCurrentLanguage($language);
        $this->$method($language, $param);
        return;
      }
    }

    $this->handleHttpError(404, "Page Not Found");
  }

  private function redirectToDefaultLanguage(): void
  {
    $defaultLanguage = 'sv'; // Set your default language here
    header("Location: /$defaultLanguage");
    exit;
  }

  private function websitePage(string $language): void
  {
    echo $this->template->getTemplate('websitePage', $this->getData());
  }

  private function isStaticFileRequest(string $uri): bool
  {
    $pathParts = explode('/', ltrim($uri, '/'));
    $firstPathPart = $pathParts[0] ?? '';

    if (in_array($firstPathPart, Url::NO_LANG_FOR_PATHS)) {
      return true;
    }

    $fileExtension = pathinfo($uri, PATHINFO_EXTENSION);
    if (in_array($fileExtension, ['css', 'js', 'jpg', 'jpeg', 'png', 'gif', 'webp', 'ico', 'map'])) {
      return true;
    }

    return false;
  }

  private function setCurrentLanguage(string $language): void
  {
    $GLOBALS['language'] = $language;
  }

  public function handleHttpError(int $errorCode, string $errorMessage): void
  {
    header("HTTP/1.0 $errorCode $errorMessage");
    echo $this->template->getTemplate('httpErrorPage', ['error_code' => $errorCode, 'error_message' => $errorMessage]);
  }

  private function startPage(string $language): void
  {
    echo $this->template->getTemplate('startPage', $this->getData(['isStartPage' => true]));
  }

  private function lettersPage(string $language): void
  {
    $letters = new Letters();

    // Retrieve query parameters
    $params = [];

    if (!empty($_GET['keywords'])) {
      $params['keywords'] = is_array($_GET['keywords']) ? $_GET['keywords'] : explode(',', $_GET['keywords']);
    }

    if (!empty($_GET['people'])) {
      $params['people'] = is_array($_GET['people']) ? $_GET['people'] : explode(',', $_GET['people']);
    }

    if (!empty($_GET['search'])) {
      $params['search'] = $_GET['search'];
    }

    // Fetch filtered letters
    $lettersData = $letters->getAllBy($params);

    // Fetch unique keywords and people
    $uniqueKeywords = $letters->getUniqueValues('keywords');
    $uniquePeople = $letters->getUniqueValues('people');

    // Pass data to template
    echo $this->template->getTemplate('lettersPage', [
      'letters' => $lettersData,
      'uniqueKeywords' => $uniqueKeywords,
      'uniquePeople' => $uniquePeople,
    ]);
  }

  private function letterPage(string $language, string $date): void
  {
    $letters = new Letters();

    // Fetch the letter by date
    $letter = $letters->getByDate($date);

    if ($letter === null) {
      $this->handleHttpError(404, "Letter Not Found");
      return;
    }

    // Pass data to template
    echo $this->template->getTemplate('letterPage', [
      'letter' => $letter,
    ]);
  }

  private function getData(array $additionalData = []): array
  {
    $data = [
      'language' => $GLOBALS['language'],
    ];
    return array_merge($data, $additionalData);
  }
}
