<?php

namespace App\Controllers;

use App\Core\Application;
use App\Services\AuthService;

class AdminController extends BaseController
{
    private $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function login()
    {
        return $this->view('admin/login');
    }

    public function authenticate()
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';

        if ($this->authService->authenticate($email, $password)) {
            $_SESSION['admin'] = true;
            return $this->redirect('/admin/registrations');
        }

        return $this->view('admin/login', ['error' => 'Invalid credentials']);
    }

    public function registrations()
    {
        if (!isset($_SESSION['admin'])) {
            return $this->redirect('/admin/login');
        }

        $db = Application::getDB();
        $registrations = $db->query('SELECT * FROM registrations ORDER BY created_at DESC')->fetchAll(\PDO::FETCH_ASSOC);

        return $this->view('admin/registrations', ['registrations' => $registrations]);
    }

    public function logout()
    {
        unset($_SESSION['admin']);
        return $this->redirect('/admin/login');
    }
}
