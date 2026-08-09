#syntax=docker/dockerfile:1

# ──────────────────────────────────────────────────────────────
# Stage 1 — PHP dependencies (composer, cached layer)
# ──────────────────────────────────────────────────────────────
FROM composer:2 AS composer
WORKDIR /app
COPY composer.json composer.lock ./
RUN --mount=type=cache,target=/root/.composer/cache \
    composer install --no-interaction --no-progress --prefer-dist --no-scripts \
    && composer dump-autoload --no-interaction --classmap-authoritative --optimize

# ──────────────────────────────────────────────────────────────
# Stage 2 — Frontend assets (Vite + Tailwind)
# ──────────────────────────────────────────────────────────────
FROM node:20-alpine AS node
WORKDIR /app
COPY package.json ./
RUN npm install --no-audit --no-fund
COPY resources/ ./resources/
COPY vite.config.js public/ ./
RUN npm run build

# ──────────────────────────────────────────────────────────────
# Stage 3 — Production runtime (PHP 8.3 + Apache)
# ──────────────────────────────────────────────────────────────
FROM php:8.3-apache
ENV DEBIAN_FRONTEND=noninteractive
ENV PORT=9000
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# System libraries + required PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
        libzip-dev libonig-dev libxml2-dev libpng-dev libjpeg62-turbo-dev \
        libfreetype6-dev libicu-dev libpq-dev default-libmysqlclient-dev libwebp-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j"$(nproc)" pdo_mysql pdo_pgsql gd mbstring exif pcntl bcmath zip opcache intl \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Point Apache DocumentRoot at the Laravel public/ directory and enable mod_rewrite
RUN rm -f /etc/apache2/sites-enabled/000-default.conf \
    && printf '<VirtualHost *:80>\n    DocumentRoot %s\n    <Directory %s>\n        Options -Indexes +FollowSymLinks\n        AllowOverride All\n        Require all granted\n    </Directory>\n</VirtualHost>\n' "${APACHE_DOCUMENT_ROOT}" "${APACHE_DOCUMENT_ROOT}" > /etc/apache2/sites-available/000-default.conf \
    && a2ensite 000-default \
    && a2enmod rewrite \
    && echo "ServerName localhost" > /etc/apache2/conf-available/servername.conf \
    && a2enconf servername

WORKDIR /var/www/html

# PHP dependencies
COPY --from=composer /app/vendor/ ./vendor/

# Built frontend assets (manifest + public/build)
COPY --from=node /app/public/build/ ./public/build/

# Application source (excludes vendor/node_modules via .dockerignore)
COPY . .

# Discover packages, link storage, fix permissions
RUN php artisan package:discover --ansi \
    && php artisan storage:link --force \
    && chmod -R 775 storage bootstrap/cache

COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 9000
ENTRYPOINT ["docker-entrypoint.sh"]
