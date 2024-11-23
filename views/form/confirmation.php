<?php $title = 'Registrazione Inviata' ?>

<div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl p-6">
    <div class="text-center">
        <h2 class="text-2xl font-bold mb-4">Registrazione Inviata</h2>
        <p class="text-gray-600 mb-4">Per favore controlla la tua email per completare il pagamento</p>
        <div class="space-y-4">
            <a href="<?= htmlspecialchars($paymentUrl) ?>" class="inline-block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Procedi al Pagamento
            </a>
            <div class="block">
                <a href="/" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Torna alla Home
                </a>
            </div>
        </div>
    </div>
</div>