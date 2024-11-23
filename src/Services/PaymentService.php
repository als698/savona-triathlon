<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentService
{
    public function __construct()
    {
        $config = require __DIR__ . '/../../config/config.php';
        Stripe::setApiKey($config['stripe']['secret_key']);
    }

    public function getPublicKey(): string
    {
        $config = require __DIR__ . '/../../config/config.php';
        return $config['stripe']['public_key'];
    }

    public function createCheckoutSession(array $registration): Session
    {
        return Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Iscrizione Triathlon di Savona',
                        'description' => "Categoria: {$registration['category']}"
                    ],
                    'unit_amount' => 5000, // €50.00
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $_ENV['APP_URL'] . '/payment/success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $_ENV['APP_URL'] . '/payment/cancel',
            'metadata' => [
                'registration_id' => $registration['id']
            ]
        ]);
    }
}
