<?php

namespace App\Services;

class EmailService
{
    public function sendPaymentLink(string $email, int $registrationId, string $name): void
    {
        $paymentUrl = sprintf(
            "%s/payment/%s/%s",
            $_ENV['APP_URL'],
            $registrationId,
            $this->generatePaymentToken($registrationId, $email)
        );

        $subject = "Completa la tua Registrazione al Triathlon";
        $message = "Gentile {$name},\n\n";
        $message .= "Per favore completa la tua registrazione effettuando il pagamento qui:\n";
        $message .= $paymentUrl . "\n\n";
        $message .= "Questo link scadrà tra 24 ore.\n";

        mail($email, $subject, $message);
    }

    public function generatePaymentToken(int $registrationId, string $email): string
    {
        return hash_hmac('sha256', $registrationId . $email, $_ENV['APP_KEY']);
    }
}
