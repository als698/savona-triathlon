<?php

return [
    'db' => [
        'path' => __DIR__ . '/../database/database.sqlite'
    ],
    'stripe' => [
        'secret_key' => getenv('STRIPE_SECRET_KEY'),
        'public_key' => getenv('STRIPE_PUBLIC_KEY'),
    ],
];
