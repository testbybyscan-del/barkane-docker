<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/Database.php';

use App\Database;

// Для обратной совместимости старых скриптов
$pdo = Database::getInstance()->getPdo();
//Чтобы не ломать обратную совместимость, 
// оставляем файл db.php, но он теперь 
// просто подключает классы и возвращает PDO