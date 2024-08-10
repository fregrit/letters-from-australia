<?php

class Template
{
  private string $partialsPath;
  private Logger $logger;

  public function __construct()
  {
    $this->logger = Logger::getInstance('template.log');
    $this->partialsPath = __DIR__ . "/../../templates/partials";
  }

  public function getTemplate(string $templateName, array $data = []): string
  {
    $filePath = __DIR__ . "/../../templates/{$templateName}.php";
    if (file_exists($filePath)) {
      ob_start();

      // Merge $GLOBALS into the data array
      $data = array_merge($GLOBALS, $data);

      // Load all letter dates and add them to the data array
      $letters = new Letters();
      $data['allLetterDates'] = $letters->getAllDates();

      extract($data);

      include $this->partialsPath . '/header.php';

      // Render errors if any exist
      if (!empty($errors)) {
        echo '<div class="container"><div class="alert alert-danger">';
        foreach ($errors as $error) {
          echo "<p>" . htmlspecialchars($error) . "</p>";
        }
        echo '</div></div>';
      }

      include $filePath;
      include $this->partialsPath . '/footer.php';
      return ob_get_clean();
    } else {
      throw new RuntimeException("Template file not found: $filePath");
    }
  }
}
