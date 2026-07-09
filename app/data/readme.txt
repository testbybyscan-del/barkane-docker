getData.json - пример переданных методом $_GET данных от index.php 
{
    "start_date": "07-01-2025",
    "end_date": "08-01-2025",
    "city": "\u0421\u0435\u0432\u0430\u0441\u0442\u043e\u043f\u043e\u043b\u044c",
    "venue": "\u043d\u0430 \u044f\u0445\u0442\u0435",
    "theme": "\u044d\u043a\u043e\u043b\u043e\u0433\u0438\u044f",
    "event_type": "\u043b\u044e\u0431\u044b\u0435",
    "for_kids": "on",
    "is_free": "on",
    "has_food": "on",
    "has_alcohol": "on",
    "has_transfer": "on"
}


Ниже - образец JSON, с которым необходимо сравнить:

{
        "id": 0,
        "name": "Кулинарный мастер-класс",
        "description": "Узнайте секреты приготовления блюд мировых кухонь.",
        "date": "2025-01-09",
        "time": "19:00",
        "venue": "концертный зал",
        "theme": "кулинария",
        "for_kids": false,
        "is_free": false,
        "has_food": true,
        "has_alcohol": false,
        "has_transfer": true,
        "event_type": "мастеркласс",
        "city": "Симферополь"
    }