<?php

use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;

class Logger
{
  private static array $instances = [];
  private MonologLogger $logger;

  private function __construct(string $logFile)
  {
    $this->logger = new MonologLogger('app');
    $this->logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/' . $logFile, MonologLogger::DEBUG));
  }

  public static function getInstance(string $logFile = 'app.log'): Logger
  {
    if (!isset(self::$instances[$logFile])) {
      self::$instances[$logFile] = new Logger($logFile);
    }
    return self::$instances[$logFile];
  }

  public function info(string $message, array $context = []): void
  {
    $this->logger->info($message, $context);
  }

  public function error(string $message, array $context = []): void
  {
    $this->logger->error($message, $context);
  }

  public function warning(string $message, array $context = []): void
  {
    $this->logger->warning($message, $context);
  }

  public function getLogger(): MonologLogger
  {
    return $this->logger;
  }
}
