-- Создание таблицы
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
    city TEXT
);

-- Импорт данных (все 10 событий)
INSERT INTO events (id, name, description, date, time, venue, theme, for_kids, is_free, has_food, has_alcohol, has_transfer, event_type, city) VALUES
(0, 'Кулинарный мастер-класс', 'Узнайте секреты приготовления блюд мировых кухонь.', '2025-01-09', '19:00', 'концертный зал', 'кулинария', false, false, true, false, true, 'мастеркласс', 'Симферополь'),
(1, 'Вечер живой музыки', 'Концерт местных музыкантов на летней площадке.', '2025-01-09', '20:00', 'на берегу моря', 'музыка', true, true, true, false, false, 'концерт', 'Ялта'),
(2, 'Лекция по экологии', 'Узнайте о важности сохранения природы.', '2025-01-10', '18:00', 'вне помещений', 'экология', false, true, false, false, false, 'лекция', 'Севастополь'),
(3, 'Дискотека под звездами', 'Ночная дискотека с DJ на открытом воздухе.', '2025-01-11', '22:00', 'ночной клуб', 'музыка', false, false, false, true, true, 'дискотека', 'Алушта'),
(4, 'Выставка местного искусства', 'Экспозиция работ художников Крыма.', '2025-01-12', '10:00', 'концертный зал', 'искусство', true, true, false, false, false, 'выставка', 'Феодосия'),
(5, 'Спортивные состязания', 'Соревнования по командным играм на стадионе.', '2025-01-13', '15:00', 'вне помещений', 'спорт', false, false, true, false, false, 'состязание', 'Керчь'),
(6, 'Творческий вечер поэтов', 'Чтение стихов и обсуждение поэзии.', '2025-01-14', '19:30', 'ночной клуб', 'искусство', false, false, false, true, true, 'творческий вечер', 'Симферополь'),
(7, 'Фестиваль здоровья', 'Организация занятий по йоге и медитации.', '2025-01-15', '08:00', 'вне помещений', 'здоровье', true, true, true, false, false, 'мастеркласс', 'Саки'),
(8, 'Автошоу 2025', 'Выставка новых моделей автомобилей.', '2025-01-16', '10:00', 'концертный зал', 'авто/мото', false, false, true, true, true, 'выставка', 'Евпатория'),
(9, 'Альпинизм и приключения', 'Организация походов и восхождений по горам.', '2025-01-17', '09:00', 'повсюду', 'альпинизм', false, false, true, false, true, 'яхтинг', 'Коктебель')
ON CONFLICT (id) DO NOTHING;
