<?php

namespace App\Controllers;

use App\Core\Application;
use App\Services\PaymentService;
use App\Services\EmailService;

class PaymentController extends BaseController
{
    private $paymentService;
    private $emailService;

    public function __construct()
    {
        $this->paymentService = new PaymentService();
        $this->emailService = new EmailService();
    }

    public function show()
    {
        $config = require __DIR__ . '/../../config/config.php';
        return $this->view('payment/form', [
            'stripeKey' => $config['stripe']['public_key'],
        ]);
    }

    public function verify($id, $token)
    {
        $db = Application::getDB();
        $registration = $db->query(
            'SELECT * FROM registrations WHERE id = :id',
            ['id' => $id]
        )->fetch();

        if (!$registration) {
            return $this->view('error', ['message' => 'Registrazione non valida']);
        }

        $expectedToken = $this->emailService->generatePaymentToken($id, $registration['email']);
        if (!hash_equals($expectedToken, $token)) {
            return $this->view('error', ['message' => 'Link di pagamento non valido']);
        }

        $config = require __DIR__ . '/../../config/config.php';
        return $this->view('payment/form', [
            'stripeKey' => $config['stripe']['public_key'],
            'registration' => $registration
        ]);
    }

    public function createSession()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!isset($data['registration_id']) || !isset($data['csrf_token'])) {
                throw new \Exception('Dati mancanti');
            }

            $db = Application::getDB();
            $registration = $db->query(
                'SELECT * FROM registrations WHERE id = :id',
                ['id' => $data['registration_id']]
            )->fetch();

            if (!$registration) {
                throw new \Exception('Registrazione non trovata');
            }

            $db->query(
                'UPDATE registrations SET payment_status = :status WHERE id = :id',
                ['status' => 'processing', 'id' => $registration['id']]
            );

            $session = $this->paymentService->createCheckoutSession($registration);

            header('Content-Type: application/json');
            echo json_encode(['id' => $session->id]);
            exit;
        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }

    public function success()
    {
        try {
            $sessionId = $_GET['session_id'] ?? null;
            if (!$sessionId) {
                throw new \Exception('Session ID mancante');
            }

            $session = \Stripe\Checkout\Session::retrieve($sessionId);
            $registrationId = $session->metadata->registration_id;

            $db = Application::getDB();
            $db->query(
                'UPDATE registrations SET payment_status = :status WHERE id = :id',
                ['status' => 'paid', 'id' => $registrationId]
            );

            return $this->redirect('/success');
        } catch (\Exception $e) {
            return $this->view('error', ['message' => $e->getMessage()]);
        }
    }

    public function cancel()
    {
        return $this->view('payment/form', [
            'error' => 'Il pagamento è stato annullato. Riprova.',
            'stripeKey' => $this->paymentService->getPublicKey(),
            'registration' => $registration ?? null
        ]);
    }

    public function process()
    {
        try {
            $token = $_POST['stripeToken'] ?? null;
            $registrationId = $_POST['registration_id'] ?? null;

            if (!$token || !$registrationId) {
                throw new \Exception('Dati di pagamento mancanti');
            }

            $db = Application::getDB();
            $registration = $db->query(
                'SELECT * FROM registrations WHERE id = :id',
                ['id' => $registrationId]
            )->fetch();

            if (!$registration) {
                throw new \Exception('Registrazione non trovata');
            }

            $charge = $this->paymentService->processPayment(50, $token);

            if ($charge->status === 'succeeded') {
                $db->query(
                    'UPDATE registrations SET payment_status = :status WHERE id = :id',
                    ['status' => 'paid', 'id' => $registrationId]
                );
                return $this->redirect('/success');
            }

            throw new \Exception('Pagamento non riuscito');
        } catch (\Exception $e) {
            return $this->view('payment/form', [
                'stripeKey' => $this->paymentService->getPublicKey(),
                'registration' => $registration ?? null,
                'error' => $e->getMessage()
            ]);
        }
    }
}
