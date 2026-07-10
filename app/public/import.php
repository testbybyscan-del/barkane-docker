<?php
// Новый API для импорта
declare(strict_types=1);

// Подключаем автозагрузку Composer
require_once __DIR__ . '/../vendor/autoload.php';

use App\EventRepository;

// Аутентификация по API-ключу (передаётся в заголовке X-API-Key)
$apiKey = $_SERVER['HTTP_X_API_KEY'] ?? '';
if ($apiKey !== getenv('IMPORT_API_KEY')) {
    http_response_code(401);
    die('Unauthorized');
}

// Чтение и валидация JSON
$input = file_get_contents('php://input');
$data = json_decode($input, true);
if ($data === null || !is_array($data)) {
    http_response_code(400);
    die('Invalid JSON');
}

try {
    $repository = new EventRepository();
    $result = $repository->importFromJson($data);

    http_response_code(200);
    echo json_encode([
        'status' => 'ok',
        'imported' => (int)($result['imported'] ?? 0),
        'errors' => isset($result['errors']) && is_string($result['errors']) 
            ? json_decode($result['errors'], true) 
            : []
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
