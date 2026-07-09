FROM php:8.3-fpm-alpine

# Установка расширений для PostgreSQL
RUN apk add --no-cache postgresql-dev \
    && docker-php-ext-install pdo_pgsql

# Установка Composer (на всякий случай, но не обязателен)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Права доступа
RUN chown -R www-data:www-data /var/www/html
USER www-data
