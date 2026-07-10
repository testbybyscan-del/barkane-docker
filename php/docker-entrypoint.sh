#!/bin/sh
set -e

# Если есть composer.json – перегенерируем автозагрузку (для разработки)
if [ -f /var/www/html/composer.json ]; then
    composer dump-autoload --optimize --no-interaction
fi

# Запускаем переданную команду (php-fpm)
exec "$@"
