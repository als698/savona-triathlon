<?php

namespace App\Services;

class CsrfService
{
    public static function generateToken(): string
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function verifyToken(?string $token): bool
    {
        if (!isset($_SESSION['csrf_token']) || !$token) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }
}
