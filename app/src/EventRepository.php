<?php
/**
 * Репозиторий для работы с событиями (таблица events)
 */

declare(strict_types=1);

namespace App;

use PDO;
use PDOException;
use RuntimeException;

class EventRepository
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Поиск событий по фильтрам
     *
     * @param array<string, mixed> $filters Ассоциативный массив фильтров
     * @return array<int, array<string, mixed>> Список событий
     * @throws RuntimeException Если запрос не удался
     */
    public function findByFilters(array $filters): array
    {
        try {
            $builder = new FilterBuilder($filters);
            [$sql, $params] = $builder->build();

            $stmt = $this->db->getPdo()->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Логирование ошибки (можно заменить на монолог или error_log)
            error_log('Database error in findByFilters: ' . $e->getMessage());
            throw new RuntimeException('Не удалось выполнить поиск событий', 0, $e);
        }
    }

    /**
     * Импорт событий из JSON-данных через хранимую процедуру
     *
     * @param array $data Данные для импорта
     * @return array Результат импорта (количество добавленных, обновлённых и т.д.)
     * @throws RuntimeException Если импорт не удался
     */
    public function importFromJson(array $data): array
    {
        try {
            $pdo = $this->db->getPdo();
            $stmt = $pdo->prepare('SELECT * FROM import_events(:json::JSONB)');
            $stmt->execute([':json' => json_encode($data)]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: ['success' => false, 'message' => 'No result'];
        } catch (PDOException $e) {
            error_log('Database error in importFromJson: ' . $e->getMessage());
            throw new RuntimeException('Не удалось импортировать события', 0, $e);
        }
    }

    /**
     * Получить одно событие по ID
     */
    public function findById(int $id): ?array
    {
        try {
            $stmt = $this->db->getPdo()->prepare('SELECT * FROM events WHERE id = :id');
            $stmt->execute([':id' => $id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: null;
        } catch (PDOException $e) {
            error_log('Database error in findById: ' . $e->getMessage());
            throw new RuntimeException('Не удалось найти событие', 0, $e);
        }
    }

    /**
     * Добавить сортировку и лимит к запросу (можно расширить FilterBuilder)
     */
    public function findByFiltersWithPagination(array $filters, int $limit, int $offset): array
    {
        $builder = new FilterBuilder($filters);
        [$sql, $params] = $builder->build();
        $sql .= " ORDER BY date DESC LIMIT :limit OFFSET :offset";
        $params[':limit'] = $limit;
        $params[':offset'] = $offset;

        $stmt = $this->db->getPdo()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
