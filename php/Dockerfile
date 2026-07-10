FROM php:8.2-fpm
RUN apt-get update && apt-get install -y git unzip libpq-dev && docker-php-ext-install pdo pdo_pgsql pgsql && apt-get clean && rm -rf /var/lib/apt/lists/*
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
RUN chown -R www-data:www-data /var/www/html
ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["php-fpm"]
