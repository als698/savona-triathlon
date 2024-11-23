<?php

namespace App\Controllers;

use App\Core\Application;
use App\Services\EmailService;

class FormController extends BaseController
{
    private $emailService;

    public function __construct()
    {
        $this->emailService = new EmailService();
    }

    public function show()
    {
        return $this->view('form/register');
    }

    public function store()
    {
        $name = $this->sanitizeString($_POST['name'] ?? '');
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $category = $this->sanitizeString($_POST['category'] ?? '');

        $data = [
            'name' => $name,
            'email' => $email,
            'category' => $category,
            'payment_status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $db = Application::getDB();
        $db->query(
            'INSERT INTO registrations (name, email, category, payment_status, created_at) 
             VALUES (:name, :email, :category, :payment_status, :created_at)',
            $data
        );

        $registrationId = $db->lastInsertId();
        $paymentUrl = sprintf(
            "%s/payment/%s/%s",
            $_ENV['APP_URL'],
            $registrationId,
            $this->emailService->generatePaymentToken($registrationId, $email)
        );

        $this->emailService->sendPaymentLink($email, $registrationId, $name);

        return $this->view('form/confirmation', [
            'message' => 'Per favore controlla la tua email per completare il pagamento',
            'paymentUrl' => $paymentUrl
        ]);
    }
}
