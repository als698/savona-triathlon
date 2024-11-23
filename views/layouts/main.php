<?php

use App\Core\View;

?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?= $title ?? 'Triathlon di Savona' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        @media (max-width: 640px) {
            .container {
                width: 100%;
            }
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <?php if (isset($_SESSION['admin'])): ?>
            <?= View::component('admin-navigation') ?>
        <?php else: ?>
            <?= View::component('navigation') ?>
        <?php endif; ?>
    </nav>

    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
        <?= $content ?>
    </main>
</body>

</html>