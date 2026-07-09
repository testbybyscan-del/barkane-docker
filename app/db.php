<?php

declare(strict_types=1);

$host = getenv('DB_HOST') ?: 'db';
$port = getenv('DB_PORT') ?: '5432';
$dbname = getenv('POSTGRES_DB') ?: 'barkane';
$user = getenv('POSTGRES_USER') ?: 'barkane';
$pass = getenv('POSTGRES_PASSWORD') ?: 'StrongPassword123!';

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    http_response_code(500);
    die('Ошибка подключения к базе данных. Пожалуйста, попробуйте позже.');
}
