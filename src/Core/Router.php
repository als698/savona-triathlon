<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get($path, $callback)
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function resolve()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $_SERVER['REQUEST_URI'];
        $path = parse_url($path, PHP_URL_PATH);

        // First try exact match
        $callback = $this->routes[$method][$path] ?? null;

        // If no exact match, try matching dynamic routes
        if (!$callback) {
            foreach ($this->routes[$method] as $route => $handler) {
                $pattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $route);
                $pattern = "#^" . $pattern . "$#";

                if (preg_match($pattern, $path, $matches)) {
                    $callback = $handler;
                    array_shift($matches); // Remove the full match
                    $params = $matches;

                    if (is_string($callback)) {
                        [$controller, $action] = explode('@', $callback);
                        $controller = "App\\Controllers\\$controller";
                        $controller = new $controller();
                        return $controller->$action(...$params);
                    }
                    break;
                }
            }
        }

        if (!$callback) {
            throw new \Exception('Route not found');
        }

        if (is_string($callback)) {
            [$controller, $action] = explode('@', $callback);
            $controller = "App\\Controllers\\$controller";
            $controller = new $controller();
            return $controller->$action();
        }
    }
}
