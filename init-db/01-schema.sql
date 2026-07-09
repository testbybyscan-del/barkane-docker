-- Только структура
CREATE TABLE IF NOT EXISTS events (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    description TEXT,
    date DATE NOT NULL,
    time TIME,
    venue TEXT,
    theme TEXT,
    for_kids BOOLEAN DEFAULT FALSE,
    is_free BOOLEAN DEFAULT FALSE,
    has_food BOOLEAN DEFAULT FALSE,
    has_alcohol BOOLEAN DEFAULT FALSE,
    has_transfer BOOLEAN DEFAULT FALSE,
    event_type TEXT,
    city TEXT,
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW()
);

CREATE INDEX idx_events_date ON events(date);
CREATE INDEX idx_events_city ON events(city);
CREATE INDEX idx_events_venue ON events(venue);
CREATE INDEX idx_events_theme ON events(theme);