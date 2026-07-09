<?php
// Обновлён, использует репозиторий
declare(strict_types=1);

require_once __DIR__ . '/../src/EventRepository.php';
require_once 'db.php'; // для $pdo (совместимость)

use App\EventRepository;

$filters = [
    'name'        => $_GET['name'] ?? null,
    'venue'       => $_GET['venue'] ?? null,
    'theme'       => $_GET['theme'] ?? null,
    'event_type'  => $_GET['event_type'] ?? null,
    'city'        => $_GET['city'] ?? null,
    'start_date'  => $_GET['start_date'] ?? null,
    'end_date'    => $_GET['end_date'] ?? null,
    'for_kids'    => isset($_GET['for_kids']),
    'is_free'     => isset($_GET['is_free']),
    'has_food'    => isset($_GET['has_food']),
    'has_alcohol' => isset($_GET['has_alcohol']),
    'has_transfer'=> isset($_GET['has_transfer']),
];

$repository = new EventRepository();
$filteredEvents = $repository->findByFilters($filters);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результаты фильтрации</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <h1>Список мероприятий</h1>
    <?php if (!empty($filteredEvents)): ?>
        <ul>
            <?php foreach ($filteredEvents as $event): ?>
                <li>
                    <?= htmlspecialchars($event['name'] ?? 'Не указано') ?> —
                    <?= htmlspecialchars($event['date'] ?? 'Не указана') ?>,
                    <?= htmlspecialchars($event['venue'] ?? 'Не указано') ?>,
                    Город: <?= htmlspecialchars($event['city'] ?? 'Не указан') ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>К сожалению, мероприятий по Вашему запросу не найдено, попробуйте изменить параметры поиска!</p>
    <?php endif; ?>
    <button onclick="location.href='favourites.php'">Сохранить в Избранное</button>
    <button onclick="location.href='index.php'">На главную</button>
</body>
</html>