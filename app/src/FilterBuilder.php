<?php
//Создание фильтров
declare(strict_types=1);

namespace App;

class FilterBuilder
{
    private array $filters;
    private array $params = [];
    private string $sql = 'SELECT * FROM events WHERE 1=1';

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function build(): array
    {
        $this->applyName();
        $this->applyVenue();
        $this->applyTheme();
        $this->applyEventType();
        $this->applyCity();
        $this->applyStartDate();
        $this->applyEndDate();
        $this->applyBooleans();

        return [$this->sql, $this->params];
    }

    private function applyName(): void
    {
        if (!empty($this->filters['name'])) {
            $this->sql .= " AND name ILIKE :name";
            $this->params[':name'] = '%' . $this->filters['name'] . '%';
        }
    }

    private function applyVenue(): void
    {
        if (!empty($this->filters['venue']) && $this->filters['venue'] !== 'любое') {
            $this->sql .= " AND venue = :venue";
            $this->params[':venue'] = $this->filters['venue'];
        }
    }

    private function applyTheme(): void
    {
        if (!empty($this->filters['theme']) && $this->filters['theme'] !== 'любая') {
            $this->sql .= " AND theme = :theme";
            $this->params[':theme'] = $this->filters['theme'];
        }
    }

    private function applyEventType(): void
    {
        if (!empty($this->filters['event_type']) && $this->filters['event_type'] !== 'любые') {
            $this->sql .= " AND event_type = :event_type";
            $this->params[':event_type'] = $this->filters['event_type'];
        }
    }

    private function applyCity(): void
    {
        if (!empty($this->filters['city']) && $this->filters['city'] !== 'повсюду') {
            $this->sql .= " AND city = :city";
            $this->params[':city'] = $this->filters['city'];
        }
    }

    private function applyStartDate(): void
    {
        if (!empty($this->filters['start_date'])) {
            $start = \DateTime::createFromFormat('d-m-Y', $this->filters['start_date']);
            if ($start) {
                $this->sql .= " AND date >= :start_date";
                $this->params[':start_date'] = $start->format('Y-m-d');
            }
        }
    }

    private function applyEndDate(): void
    {
        if (!empty($this->filters['end_date'])) {
            $end = \DateTime::createFromFormat('d-m-Y', $this->filters['end_date']);
            if ($end) {
                $this->sql .= " AND date <= :end_date";
                $this->params[':end_date'] = $end->format('Y-m-d');
            }
        }
    }

    private function applyBooleans(): void
    {
        $boolFields = ['for_kids', 'is_free', 'has_food', 'has_alcohol', 'has_transfer'];
        foreach ($boolFields as $field) {
            if ($this->filters[$field] ?? false) {
                $this->sql .= " AND $field = true";
            }
        }
    }
}