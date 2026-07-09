<?php
//Новая обёртка PDO
declare(strict_types=1);

namespace App;

use PDO;
use PDOException;

class Database
{
    private static ?self $instance = null;
    private PDO $pdo;

    private function __construct()
    {
        $host = getenv('DB_HOST') ?: 'db';
        $port = getenv('DB_PORT') ?: '5432';
        $dbname = getenv('POSTGRES_DB') ?: 'barkane';
        $user = getenv('POSTGRES_USER') ?: 'barkane';
        $pass = getenv('POSTGRES_PASSWORD') ?: 'StrongPassword123!';

        try {
            $this->pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            http_response_code(500);
            die('Ошибка подключения к базе данных. Пожалуйста, попробуйте позже.');
        }
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}