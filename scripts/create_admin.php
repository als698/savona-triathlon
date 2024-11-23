<?php

require_once __DIR__ . '/../vendor/autoload.php';

$email = 'test@test.com';
$password = 'test25';

$db = new PDO('sqlite:' . __DIR__ . '/../database/database.sqlite');
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $db->prepare('INSERT INTO admins (email, password) VALUES (:email, :password)');
$stmt->execute([
    'email' => $email,
    'password' => $hashedPassword
]);

echo "Admin user created successfully!\n";
