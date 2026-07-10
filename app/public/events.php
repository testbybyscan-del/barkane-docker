<?php
// Обновлён, использует репозиторий
declare(strict_types=1);

// Подключаем автозагрузку Composer
require_once __DIR__ . '/../vendor/autoload.php';

use App\EventRepository;

$filters = [
    'start_date' => $_GET['start_date'] ?? null,
    'end_date'   => $_GET['end_date']   ?? null,
    'city'       => $_GET['city']       ?? null,
    'venue'      => $_GET['venue']      ?? null,
    'theme'      => $_GET['theme']      ?? null,
    'event_type' => $_GET['event_type'] ?? null,
    // Булевы поля можно добавить, если они передаются
    'for_kids'    => isset($_GET['for_kids'])    ? (bool)$_GET['for_kids'] : false,
    'is_free'     => isset($_GET['is_free'])     ? (bool)$_GET['is_free']  : false,
    'has_food'    => isset($_GET['has_food'])    ? (bool)$_GET['has_food'] : false,
    'has_alcohol' => isset($_GET['has_alcohol']) ? (bool)$_GET['has_alcohol'] : false,
    'has_transfer' => isset($_GET['has_transfer']) ? (bool)$_GET['has_transfer'] : false,
];

$repository = new EventRepository();
$events = $repository->findByFilters($filters);

header('Content-Type: application/json');
echo json_encode($events, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
