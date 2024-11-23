<?php

$dbPath = __DIR__ . '/database.sqlite';

// Create database file if it doesn't exist
if (!file_exists($dbPath)) {
    touch($dbPath);
}

// Run all migrations from migrations directory
$migrationsDir = __DIR__ . '/migrations';
$migrations = glob($migrationsDir . '/*.php');
// Sort migrations by filename to ensure proper order
sort($migrations);

foreach ($migrations as $migration) {
    echo "Running migration: " . basename($migration) . "\n";
    require_once $migration;
}

echo "Database initialized successfully!\n";
