<?php

namespace App\Core;

class Database
{
    private \PDO $pdo;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/config.php';
        if (!file_exists($config['db']['path'])) {
            throw new \RuntimeException('Database file does not exist. Please run database/init.php first.');
        }

        $this->pdo = new \PDO('sqlite:' . $config['db']['path']);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function query($sql, $params = [])
    {
        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);
        return $statement;
    }

    public function lastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }
}
