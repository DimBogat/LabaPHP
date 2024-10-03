<?php

namespace App\Rdb;

use PDO;
use PDOException;

class SqlHelper
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pingDb();
    }

    public function openDbConnection(): PDO
    {
        try {
            $dsn = 'mysql:host=localhost;dbname=WorldCountriesDirectoryApp';
            $user = 'your_mysql_user';
            $password = 'your_mysql_password';
            $this->pdo = new PDO($dsn, $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        } catch (PDOException $e) {
            die("Ошибка подключения к базе данных: " . $e->getMessage());
        }
    }

    private function pingDb(): void
    {
        try {
            $this->pdo = $this->openDbConnection();
            $this->pdo = null;
        } catch (PDOException $e) {
            die("Ошибка проверки доступности базы данных: " . $e->getMessage());
        }
    }
}