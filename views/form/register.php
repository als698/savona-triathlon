<?php

use App\Core\View;

$title = 'Modulo di Registrazione' ?>

<div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl p-6">
    <h2 class="text-2xl font-bold mb-6">Registrati al Triathlon</h2>

    <form action="/form" method="POST">
        <?= View::component('csrf-field', ['csrf_token' => $csrf_token]) ?>

        <?= View::component('form-field', [
            'type' => 'text',
            'name' => 'name',
            'label' => 'Nome Completo',
            'required' => true,
        ]) ?>

        <?= View::component('form-field', [
            'type' => 'email',
            'name' => 'email',
            'label' => 'Indirizzo Email',
            'required' => true,
        ]) ?>

        <?= View::component('form-field', [
            'type' => 'select',
            'name' => 'category',
            'label' => 'Categoria',
            'required' => true,
        ]) ?>

        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
            Procedi al Pagamento
        </button>
    </form>
</div>