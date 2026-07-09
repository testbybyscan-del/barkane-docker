<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Расписание мероприятий в Крыму</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <style>
        /* Стили уже в styles.css, но можно оставить для переопределения */
    </style>
</head>
<body>
    <header>
        <div id="barkane-animation">
            <img src="640360barkane.jpg" alt="Barkane logo">
        </div>
    </header>

    <form action="events.php" method="get">
        <label>Укажите удобный Вам диапазон дат проведения мероприятия:</label>
        <input type="text" id="start_date" name="start_date" readonly placeholder="С">
        <input type="text" id="end_date" name="end_date" readonly placeholder="По">
        <script src="datepicker.js"></script>

        <label for="city">Укажите топоним Крыма:</label>
        <select name="city" id="city">
            <option value="повсюду">Поиск мероприятия по всему Крыму</option>
            <option value="Симферополь">Симферополь</option>
            <option value="Севастополь">Севастополь</option>
            <option value="Балаклава">Балаклава</option>
            <option value="Евпатория">Евпатория</option>
            <option value="мыс Тарханкут">мыс Тарханкут</option>
            <option value="Ялта">Ялта</option>
            <option value="Ливадия">Ливадия</option>
            <option value="Массандра">Массандра</option>
            <option value="Саки">Саки</option>
            <option value="Феодосия">Феодосия</option>
            <option value="Керчь">Керчь</option>
            <option value="Алушта">Алушта</option>
            <option value="Алупка">Алупка</option>
            <option value="Гурзуф">Гурзуф</option>
            <option value="Симеиз">Симеиз</option>
            <option value="Кореиз">Кореиз</option>
            <option value="Гаспра">Гаспра</option>
            <option value="Коктебель">Коктебель</option>
            <option value="Судак">Судак</option>
            <option value="Новый Свет">Новый Свет</option>
            <option value="мыс Меганом">мыс Меганом</option>
            <option value="Бахчисарай">Бахчисарай</option>
            <option value="Старый Крым">Старый Крым</option>
        </select>

        <label for="venue">Укажите удобное Вам место проведения мероприятия:</label>
        <select name="venue" id="venue">
            <option value="любое">Любое место</option>
            <option value="концертный зал">Концертный зал</option>
            <option value="ночной клуб">Ночной клуб</option>
            <option value="вне помещений">Вне помещений</option>
            <option value="на берегу моря">На берегу моря</option>
            <option value="на яхте">На яхте</option>
            <option value="музей">Музей</option>
        </select>

        <label for="theme">Укажите тематику мероприятия:</label>
        <select name="theme" id="theme">
            <option value="любая">Любая тематика</option>
            <option value="музыка">Музыка</option>
            <option value="искусство">Искусство</option>
            <option value="кулинария">Кулинария</option>
            <option value="здоровье">Здоровье</option>
            <option value="спорт">Спорт</option>
            <option value="авто/мото">Авто/мото</option>
            <option value="альпинизм">Альпинизм</option>
            <option value="история">История</option>
            <option value="этнография">Этнография</option>
            <option value="общество">Социум</option>
            <option value="экология">Экология</option>
        </select>

        <label for="event_type">Укажите тип мероприятия:</label>
        <select name="event_type" id="event_type">
            <option value="любые">Любое мероприятие</option>
            <option value="концерт">Концерт</option>
            <option value="лекция">Лекция</option>
            <option value="выставка">Выставка</option>
            <option value="мастеркласс">Мастер-класс</option>
            <option value="яхтинг">Прогулка на яхте</option>
            <option value="творческий вечер">Творческий вечер</option>
            <option value="дискотека">Дискотека</option>
            <option value="состязание">Состязание</option>
        </select>

        <script src="check.js"></script>
        <label><input type="checkbox" name="for_kids" onclick="toggleCheckbox('for_kids', 'for_kids')"> Для детей</label><br>
        <label><input type="checkbox" name="is_free"> Бесплатное</label><br>
        <label><input type="checkbox" name="has_food"> С фуршетом</label><br>
        <label><input type="checkbox" name="has_alcohol" onclick="toggleCheckbox('has_alcohol', 'has_alcohol')"> С алкоголем</label><br>
        <label><input type="checkbox" name="has_transfer"> С трансфером</label><br>

        <input type="submit" value="Применить фильтры">
    </form>

    <script src="filters.js"></script>
    <script src="rotation.js"></script>
</body>
</html>
