<?php

class ErrorHandler
{
  private Logger $logger;

  public function __construct()
  {
    $this->logger = Logger::getInstance();
  }

  public function handleErrors(int $severity, string $message, string $file, int $line): void
  {
    if (!(error_reporting() & $severity)) {
      return;
    }
    $this->logger->error("Error: [$severity] $message in $file on line $line");

    $GLOBALS['errors'][] = "Error: [$severity] $message in $file on line $line";

    $router = new Router();
    $router->handleHttpError(500, "Internal Server Error");
    exit;
  }

  public function handleExceptions(Throwable $exception): void
  {
    $this->logger->error("Uncaught exception: " . $exception->getMessage());

    $GLOBALS['errors'][] = $exception->getMessage();

    $router = new Router();
    $router->handleHttpError(500, "Internal Server Error");
    exit;
  }

  public function register(): void
  {
    set_error_handler([$this, 'handleErrors']);
    set_exception_handler([$this, 'handleExceptions']);
  }
}
