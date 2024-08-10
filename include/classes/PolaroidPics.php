<?php

class PolaroidPics
{
  const POLAROID_DIR = __DIR__ . '/../../www/images/polaroids/';
  
  public static function getRandom(): string
  {
    $images = glob(self::POLAROID_DIR . '*.jpeg');
    if (empty($images)) {
      throw new RuntimeException('No images found in the polaroid directory.');
    }
    $randomImage = $images[array_rand($images)];
    return Url::getInstance()->buildUrl('images/polaroids/' . basename($randomImage));
  }

  public static function getByFilename(string $filename): string
  {
    $filePath = self::POLAROID_DIR . $filename;
    if (!file_exists($filePath)) {
      throw new RuntimeException("Image not found: $filename");
    }
    return Url::getInstance()->buildUrl('images/polaroids/' . $filename);
  }
}
