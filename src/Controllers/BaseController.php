<?php

namespace App\Controllers;

use App\Core\View;
use App\Services\CsrfService;

abstract class BaseController
{
    protected function view($name, $params = [])
    {
        $params['csrf_token'] = CsrfService::generateToken();
        $content = View::make($name, $params);
        return View::make('layouts/main', ['content' => $content]);
    }

    protected function redirect($path)
    {
        header("Location: $path");
        exit();
    }

    protected function sanitizeString(?string $value): string
    {
        if ($value === null) {
            return '';
        }
        $value = trim($value);
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
    }
}
