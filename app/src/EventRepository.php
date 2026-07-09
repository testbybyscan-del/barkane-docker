<?php
//Работа с событиями
declare(strict_types=1);

namespace App;

class EventRepository
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function findByFilters(array $filters): array
    {
        $builder = new FilterBuilder($filters);
        [$sql, $params] = $builder->build();

        $stmt = $this->db->getPdo()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function importFromJson(array $data): array
    {
        $pdo = $this->db->getPdo();
        $stmt = $pdo->prepare('SELECT * FROM import_events(:json::JSONB)');
        $stmt->execute([':json' => json_encode($data)]);
        return $stmt->fetch();
    }
}