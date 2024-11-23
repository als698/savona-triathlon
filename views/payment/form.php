<?php $title = 'Pagamento Iscrizione' ?>

<div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl p-6">
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold">Completa il Pagamento</h2>

        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <div class="mt-4">
            <p class="text-gray-600 mb-2">Dettagli Registrazione:</p>
            <p><strong>Nome:</strong> <?= htmlspecialchars($registration['name']) ?></p>
            <p><strong>Categoria:</strong> <?= htmlspecialchars($registration['category']) ?></p>
            <p><strong>Importo:</strong> €50,00</p>
            <p><strong>Stato:</strong>
                <?php
                switch ($registration['payment_status']) {
                    case 'pending':
                        echo 'In attesa di pagamento';
                        break;
                    case 'processing':
                        echo 'Pagamento in elaborazione';
                        break;
                    case 'paid':
                        echo 'Pagato';
                        break;
                }
                ?>
            </p>
        </div>

        <?php if ($registration['payment_status'] === 'pending'): ?>
            <button id="checkout-button" class="mt-6 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Procedi al Pagamento
            </button>
        <?php endif; ?>
    </div>
</div>

<?php
$stripePublicKey = htmlspecialchars($stripeKey);
if (empty($stripePublicKey)) {
    echo '<div class="text-red-500">Error: Stripe public key is not configured.</div>';
}
?>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripeKey = '<?= $stripePublicKey ?>';
    if (!stripeKey) {
        console.error('Stripe public key is missing');
    }

    const stripe = Stripe(stripeKey);
    const checkoutButton = document.getElementById('checkout-button');

    if (checkoutButton) {
        checkoutButton.addEventListener('click', function(e) {
            e.preventDefault();
            checkoutButton.disabled = true;

            fetch('/payment/create-session', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        registration_id: '<?= $registration['id'] ?>',
                        csrf_token: '<?= $_SESSION['csrf_token'] ?>'
                    })
                })
                .then(response => response.json())
                .then(session => {
                    if (session.error) {
                        throw new Error(session.error);
                    }
                    return stripe.redirectToCheckout({
                        sessionId: session.id
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Si è verificato un errore. Riprova più tardi.');
                    checkoutButton.disabled = false;
                });
        });
    }
</script>