<?php

namespace App\Services;

use App\Core\Application;

class AuthService
{
    public function authenticate(string $email, string $password): bool
    {
        $db = Application::getDB();
        $stmt = $db->query(
            'SELECT * FROM admins WHERE email = :email LIMIT 1',
            ['email' => $email]
        );

        $admin = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$admin) {
            return false;
        }

        return password_verify($password, $admin['password']);
    }
}
