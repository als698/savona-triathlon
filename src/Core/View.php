<?php

namespace App\Core;

class View
{
    public static function make($view, $params = [])
    {
        extract($params);
        ob_start();
        include __DIR__ . "/../../views/{$view}.php";
        return ob_get_clean();
    }

    public static function component($name, $params = [])
    {
        return self::make("components/{$name}", $params);
    }
}
