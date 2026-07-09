<?php

declare(strict_types=1);

require_once 'db.php';

// Сбор параметров фильтрации
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

// Построение запроса
$sql = "SELECT * FROM events WHERE 1=1";
$params = [];

if (!empty($filters['name'])) {
    $sql .= " AND name ILIKE :name";
    $params[':name'] = '%' . $filters['name'] . '%';
}
if (!empty($filters['venue']) && $filters['venue'] !== 'любое') {
    $sql .= " AND venue = :venue";
    $params[':venue'] = $filters['venue'];
}
if (!empty($filters['theme']) && $filters['theme'] !== 'любая') {
    $sql .= " AND theme = :theme";
    $params[':theme'] = $filters['theme'];
}
if (!empty($filters['event_type']) && $filters['event_type'] !== 'любые') {
    $sql .= " AND event_type = :event_type";
    $params[':event_type'] = $filters['event_type'];
}
if (!empty($filters['city']) && $filters['city'] !== 'повсюду') {
    $sql .= " AND city = :city";
    $params[':city'] = $filters['city'];
}
if (!empty($filters['start_date'])) {
    $start = DateTime::createFromFormat('d-m-Y', $filters['start_date']);
    if ($start) {
        $sql .= " AND date >= :start_date";
        $params[':start_date'] = $start->format('Y-m-d');
    }
}
if (!empty($filters['end_date'])) {
    $end = DateTime::createFromFormat('d-m-Y', $filters['end_date']);
    if ($end) {
        $sql .= " AND date <= :end_date";
        $params[':end_date'] = $end->format('Y-m-d');
    }
}
foreach (['for_kids', 'is_free', 'has_food', 'has_alcohol', 'has_transfer'] as $boolField) {
    if ($filters[$boolField]) {
        $sql .= " AND $boolField = true";
    }
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$filteredEvents = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результаты фильтрации</title>
    <link rel="stylesheet" href="styles.css">
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
