FROM ambientum/php:8.1-nginx

COPY . /var/www/app

USER root

RUN chown -R ambientum:ambientum /var/www && chmod -R 775 /var/www

USER ambientum

RUN composer install --no-scripts && cp .env.example .env && php artisan key:generate --env=production