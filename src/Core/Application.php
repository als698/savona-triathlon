<?php

namespace App\Core;

use App\Middleware\CsrfMiddleware;

class Application
{
    private static Database $db;
    private $csrfMiddleware;

    public function __construct()
    {
        session_start();
        $this->loadEnvironmentVariables();
        self::$db = new Database();
        $this->csrfMiddleware = new CsrfMiddleware();
    }

    private function loadEnvironmentVariables()
    {
        $envFile = __DIR__ . '/../../.env';
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
                    list($key, $value) = explode('=', $line, 2);
                    $key = trim($key);
                    $value = trim($value);
                    putenv("$key=$value");
                    $_ENV[$key] = $value;
                }
            }
        }
    }

    public function run(Router $router)
    {
        try {
            $this->csrfMiddleware->handle();
            echo $router->resolve();
        } catch (\Exception $e) {
            echo $this->renderError($e->getMessage());
        }
    }

    public static function getDB(): Database
    {
        return self::$db;
    }

    private function renderError($message)
    {
        $content =  View::make('error', ['message' => $message]);
        return View::make('layouts/main', ['content' => $content]);
    }
}
