-- Функции и триггеры
-- Функция обновления updated_at
CREATE OR REPLACE FUNCTION update_updated_at()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = NOW();
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER events_updated_at
BEFORE UPDATE ON events
FOR EACH ROW EXECUTE FUNCTION update_updated_at();

-- Функция импорта из JSON (используется API)
CREATE OR REPLACE FUNCTION import_events(json_data JSONB)
RETURNS TABLE(imported INT, errors TEXT[]) AS $$
DECLARE
    rec RECORD;
    err_list TEXT[] := '{}';
    counter INT := 0;
BEGIN
    FOR rec IN SELECT * FROM jsonb_to_recordset(json_data) AS (
        id INT,
        name TEXT,
        description TEXT,
        date DATE,
        time TIME,
        venue TEXT,
        theme TEXT,
        for_kids BOOLEAN,
        is_free BOOLEAN,
        has_food BOOLEAN,
        has_alcohol BOOLEAN,
        has_transfer BOOLEAN,
        event_type TEXT,
        city TEXT
    )
    LOOP
        IF rec.name IS NULL OR rec.date IS NULL THEN
            err_list := array_append(err_list, 'Missing required fields for id ' || COALESCE(rec.id::TEXT, 'NULL'));
            CONTINUE;
        END IF;

        INSERT INTO events (
            id, name, description, date, time, venue, theme,
            for_kids, is_free, has_food, has_alcohol, has_transfer, event_type, city
        ) VALUES (
            rec.id, rec.name, rec.description, rec.date, rec.time, rec.venue, rec.theme,
            COALESCE(rec.for_kids, FALSE),
            COALESCE(rec.is_free, FALSE),
            COALESCE(rec.has_food, FALSE),
            COALESCE(rec.has_alcohol, FALSE),
            COALESCE(rec.has_transfer, FALSE),
            rec.event_type, rec.city
        ) ON CONFLICT (id) DO UPDATE SET
            name = EXCLUDED.name,
            description = EXCLUDED.description,
            date = EXCLUDED.date,
            time = EXCLUDED.time,
            venue = EXCLUDED.venue,
            theme = EXCLUDED.theme,
            for_kids = EXCLUDED.for_kids,
            is_free = EXCLUDED.is_free,
            has_food = EXCLUDED.has_food,
            has_alcohol = EXCLUDED.has_alcohol,
            has_transfer = EXCLUDED.has_transfer,
            event_type = EXCLUDED.event_type,
            city = EXCLUDED.city;

        counter := counter + 1;
    END LOOP;

    RETURN QUERY SELECT counter, err_list;
END;
$$ LANGUAGE plpgsql;