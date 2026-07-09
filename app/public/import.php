<?php
//Новый API для импорта
declare(strict_types=1);

require_once __DIR__ . '/../src/EventRepository.php';

use App\EventRepository;

// Аутентификация по API-ключу
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
        'errors' => $result['errors'] ? json_decode($result['errors']) : []
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}