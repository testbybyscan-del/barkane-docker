<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

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
$events = $repository->findByFilters($filters);

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Детали событий</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
<?php if (!empty($_GET)): ?>
    <?php if (count($events) > 0): ?>
        <h2>Найденные события:</h2>
        <?php foreach ($events as $event): ?>
            <ul>
                <?php foreach ($event as $key => $value): ?>
                    <li><strong><?= htmlspecialchars($key) ?>:</strong> 
                        <?php
                        if (is_bool($value)) {
                            echo $value ? 'Да' : 'Нет';
                        } else {
                            echo htmlspecialchars((string)($value ?? ''));
                        }
                        ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <hr>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Совпадений не найдено.</p>
    <?php endif; ?>
<?php else: ?>
    <p>Нет данных для поиска.</p>
<?php endif; ?>
<button onclick="location.href='index.php'">На главную</button>
</body>
</html>