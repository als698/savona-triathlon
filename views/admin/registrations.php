<?php $title = 'Iscrizioni' ?>

<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Iscrizioni</h2>
        <a href="/admin/logout" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
            Esci
        </a>
    </div>

    <div class="bg-white shadow-md rounded my-6">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Nome</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">Categoria</th>
                    <th class="py-3 px-6 text-left">Stato Pagamento</th>
                    <th class="py-3 px-6 text-left">Data Iscrizione</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <?php foreach ($registrations as $registration): ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6"><?= htmlspecialchars($registration['name']) ?></td>
                        <td class="py-3 px-6"><?= htmlspecialchars($registration['email']) ?></td>
                        <td class="py-3 px-6"><?= htmlspecialchars($registration['category']) ?></td>
                        <td class="py-3 px-6"><?= htmlspecialchars($registration['payment_status']) ?></td>
                        <td class="py-3 px-6"><?= htmlspecialchars($registration['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>