**Анализ структуры моей директории `D:\PHP\barkane-docker`**

Я провёл полный аудит своего проекта. Вот что у меня есть.

---

### Текстовое описание структуры

Корневая папка **`barkane-docker`** содержит:

- **`.git`** – служебная папка Git.
- **`app`** – основная папка приложения. Внутри неё:
  - `css/`, `data/`, `images/` – статика и данные.
  - `js/` – скрипты: `rotation.js`, `check.js`, `datepicker.js`, `filters.js`.
  - `public/` – публичная директория (точка входа веб-сервера): `index.php`, `db.php`, `events.php`, `eventsget.php`, `import.php`.
  - `src/` – PHP-классы: `FilterBuilder.php`, `Database.php`, `EventRepository.php`.
  - `vendor/` – зависимости Composer.
  - В корне `app/` также лежат: `composer.json`, `composer.lock`, `composer.phar`, а также `db.php`, `events.php`, `eventsget.php`, `favourites.php`, `index.php` – это дубликаты (см. ниже).
- **`init-db`** – скрипты инициализации БД: `init.sql`, `01-schema.sql`, `02-functions.sql`.
- **`nginx`** – папка с конфигурацией Nginx (содержимое не указано, но у меня есть `default.conf`).
- **`php`** – настройки PHP-контейнера: `docker-entrypoint.sh`, `Dockerfile`.
- В корне проекта: `.env`, `.gitignore`, `docker-compose.yml`, `structure` (папка или файл).

---

### Графическое представление (ASCII-дерево)

```
barkane-docker/
├── .git/
├── app/
│   ├── css/
│   ├── data/
│   ├── images/
│   ├── js/
│   │   ├── rotation.js
│   │   ├── check.js
│   │   ├── datepicker.js
│   │   └── filters.js
│   ├── public/
│   │   ├── index.php
│   │   ├── db.php
│   │   ├── events.php
│   │   ├── eventsget.php
│   │   └── import.php
│   ├── src/
│   │   ├── FilterBuilder.php
│   │   ├── Database.php
│   │   └── EventRepository.php
│   ├── vendor/
│   ├── composer.json
│   ├── composer.lock
│   ├── composer.phar
│   ├── db.php ⚠️ дубликат (см. public/db.php)
│   ├── events.php ⚠️ дубликат (см. public/events.php)
│   ├── eventsget.php ⚠️ дубликат (см. public/eventsget.php)
│   ├── favourites.php
│   └── index.php ⚠️ дубликат (см. public/index.php)
├── init-db/
│   ├── init.sql
│   ├── 01-schema.sql
│   └── 02-functions.sql
├── nginx/
├── php/
│   ├── docker-entrypoint.sh
│   └── Dockerfile
├── .env
├── .gitignore
├── docker-compose.yml
└── structure/
```

---

### Выявленные мной потенциальные дубликаты файлов

Я обнаружил четыре пары файлов с одинаковыми именами в двух разных директориях:


| Имя файла | Путь 1          | Путь 2                 |
| ----------------- | ------------------- | -------------------------- |
| `index.php`       | `app/index.php`     | `app/public/index.php`     |
| `db.php`          | `app/db.php`        | `app/public/db.php`        |
| `events.php`      | `app/events.php`    | `app/public/events.php`    |
| `eventsget.php`   | `app/eventsget.php` | `app/public/eventsget.php` |

---

### Мои рекомендации по дубликатам

1. Я должен проверить содержимое каждой пары. Если они идентичны – это избыточное дублирование. Тогда я оставлю только одну копию (скорее всего, в `public/`, так как это публичная директория).
2. Если файлы различаются по назначению – я переименую или перемещу их, чтобы избежать путаницы. Например, файлы в корне `app/` могут быть вспомогательными, а в `public/` – точками входа.
3. Я также проверю `docker-compose.yml` и настройки веб-сервера – правильно ли указан корневой каталог документов (обычно `./app/public`).

---

### Проверка каталога документа (document root) в моём `docker-compose.yml`

В моём файле `docker-compose.yml` **нет прямого указания** document root для Nginx. Этот параметр задаётся в конфигурационном файле Nginx (`nginx/default.conf`), который монтируется в контейнер. Из настроек томов я вижу:

- **Сервис `php`** монтирует `./app` в `/var/www/html`
- **Сервис `nginx`** монтирует ту же папку `./app` в `/var/www/html`
- **Сервис `nginx`** дополнительно монтирует `./nginx/default.conf` в `/etc/nginx/conf.d/default.conf`

**Где должен быть document root?**
Судя по моей структуре, публичные файлы лежат в подпапке `app/public/`. Это типичная практика для PHP‑приложений (например, Symfony, Laravel). Следовательно, **в `default.conf` должен быть указан корень**:

```nginx
root /var/www/html/public;
```

---

### Что я должен проверить в `default.conf`

1. Открыть файл `nginx/default.conf` и найти директиву `root`.

   - Если там прописано `root /var/www/html;` (без `/public`), то Nginx будет отдавать файлы из корня `app/`, а не из `app/public/`.
   - Тогда при обращении к сайту будет загружаться `app/index.php` (если он существует), а не `app/public/index.php`. Это может привести к конфликту из-за дублирующихся файлов.
2. Убедиться, что `default.conf` содержит правильный блок:

```nginx
server {
    listen 80;
    server_name localhost;
    root /var/www/html/public;
    index index.php index.html;
    ...
}
```

---

### Мои рекомендации по устранению дублирования

Поскольку в корне `app/` также лежат `index.php`, `db.php`, `events.php`, `eventsget.php`, а в `app/public/` – их копии, я планирую:

- **Оставить только файлы в `public/`**, если они являются точками входа.
- **Удалить дубликаты из `app/`**, чтобы избежать путаницы и случайного доступа к ним через веб (если document root будет неправильно настроен).
- Если какие-то файлы в корне `app/` имеют другое назначение (например, вспомогательные скрипты), я перемещу их в отдельную папку (например, `app/bin/` или `app/scripts/`).

---

### Проверка после изменений

После корректировки `default.conf` и удаления дубликатов я перезапущу контейнеры:

```bash
docker-compose down && docker-compose up -d
```

И проверю работу приложения через `http://localhost:8099` (или другой порт, который я использую).

---

### Проверка моей конфигурации Nginx (`default.conf`)

Я проверил – конфигурация **корректна**:

- **`root /var/www/html/public;`** – правильно указывает на публичную директорию, где лежат точки входа (`index.php` и др.).
- Блок `location ~ \.php$` корректно передаёт PHP-запросы на сервис `php:9000` с параметром `SCRIPT_FILENAME`, который формируется как `$document_root$fastcgi_script_name` – это обеспечивает обработку файлов именно из `public/`.
- Алиасы для статики (`/css/`, `/js/`, `/images/`) указывают на папки в `/var/www/html/` (корень `app/`), что соответствует структуре проекта (статичные файлы лежат вне `public`).

---

### Остаётся проблема дублирования файлов

Несмотря на правильный `root`, в корне `app/` присутствуют файлы-дубликаты (`index.php`, `db.php`, `events.php`, `eventsget.php`). Они **не будут доступны через веб** (поскольку Nginx смотрит в `public/`), но:

- Могут случайно подключаться через `include`/`require` в моём коде (если я использую относительные пути без учёта `__DIR__`).
- Создают путаницу при разработке и сопровождении проекта.

**Моя рекомендация самому себе**: удалить эти дублирующиеся файлы из `app/`, оставив только их версии в `app/public/`. Если какие-то из них имеют иное назначение (например, вспомогательные скрипты для CLI), я перемещу их в отдельную папку (например, `app/bin/`) и переименую, чтобы избежать конфликтов имён.

---

### Итог

- Мой `default.conf` настроен верно.
- Дублирование файлов не влияет на работу веб-сервера, но является архитектурным недостатком – я исправлю это для чистоты проекта.
