<?php

namespace App\Middleware;

use App\Services\CsrfService;

class CsrfMiddleware
{
    public function handle()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = null;

            // Check if it's a JSON request
            if (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
                $jsonData = json_decode(file_get_contents('php://input'), true);
                $token = $jsonData['csrf_token'] ?? null;
            } else {
                $token = $_POST['csrf_token'] ?? null;
            }

            if (!CsrfService::verifyToken($token)) {
                http_response_code(403);
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
                    header('Content-Type: application/json');
                    echo json_encode(['error' => 'CSRF token validation failed']);
                    exit;
                }
                die('CSRF token validation failed');
            }
        }
    }
}
