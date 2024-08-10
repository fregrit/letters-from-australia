<?php

class Letters
{
  private array $letters;
  private string $language;
  private array $allDates = [];

  public function __construct()
  {
    $this->language = $GLOBALS['language'] ?? 'en';
    $this->loadLetters();
  }

  public function getAllDates(): array
  {
    return $this->allDates;
  }

  private function loadLetters(): void
  {
    $filePath = __DIR__ . '/../../data/letters.json';

    if (!file_exists($filePath)) {
      throw new RuntimeException("Letters file not found: $filePath");
    }

    $data = json_decode(file_get_contents($filePath), true);

    if (json_last_error() !== JSON_ERROR_NONE) {
      throw new RuntimeException("Invalid JSON in letters file");
    }

    $this->letters = $data['letters'];
    
    // Sort letters by date (earliest first)
    usort($this->letters, fn($a, $b) => strtotime($a['date']) <=> strtotime($b['date']));

    // Populate allDates array, which will already be in the correct order
    foreach ($this->letters as $letter) {
      $this->allDates[] = $letter['date'];
    }
  }

  public function getAllBy(array $params = []): array
  {
    $filteredLetters = $this->letters;
  
    foreach ($params as $key => $value) {
      $filteredLetters = array_filter($filteredLetters, function ($letter) use ($key, $value) {
        if ($key === 'search') {
          return stripos($letter['content_' . $this->language], $value) !== false;
        } elseif ($key === 'people') {
          // Ensure all specified people match
          return !array_diff((array)$value, $letter['people']);
        } elseif ($key === 'keywords') {
          // Ensure all specified keywords match
          return !array_diff((array)$value, $letter['keywords_' . $this->language]);
        }
        return true;
      });
    }
  
    return array_map([$this, 'removeLanguageSuffix'], $filteredLetters);
  }
  
  public function getByDate(string $date): ?array
  {
    foreach ($this->letters as $letter) {
      if ($letter['date'] === $date) {
        return $this->removeLanguageSuffix($letter);
      }
    }
    return null;
  }

  public function getUniqueValues(string $key): array
  {
    $values = [];
    $key = $key . '_' . $this->language; // Adjust key to be language-specific
    foreach ($this->letters as $letter) {
      if (isset($letter[$key])) {
        $values = array_merge($values, $letter[$key]);
      }
    }
    return array_unique($values);
  }

  private function removeLanguageSuffix(array $letter): array
  {
    $suffix = '_' . $this->language;
    $keysToRemove = array_filter(array_keys($letter), fn($key) => str_ends_with($key, $suffix));
    foreach ($keysToRemove as $key) {
      $newKey = str_replace($suffix, '', $key);
      $letter[$newKey] = $letter[$key];
      unset($letter[$key]);
    }
    return $letter;
  }
}
