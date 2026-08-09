#!/bin/sh
set -e

cd /var/www/html

# Render assigns the port the container must listen on via $PORT (default 9000)
PORT="${PORT:-9000}"
export PORT

# Make Apache listen on the Render port
sed -i "s/^\(#*\)\s*Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s|<VirtualHost \*:80>|<VirtualHost *:${PORT}>|" /etc/apache2/sites-available/000-default.conf

# Make sure the web uid can write to storage & bootstrap cache
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

# Generate an app key if one was not provided
if [ -z "${APP_KEY:-}" ]; then
    php artisan key:generate --force
fi

# Run pending migrations (best-effort: never block the container from starting)
php artisan migrate --force --no-interaction || echo "warn: migrate failed (will retry next deploy)"

# Warm the caches now that the environment is available
php artisan config:cache --force           2>/dev/null || true
php artisan route:cache                     2>/dev/null || true
php artisan view:cache                      2>/dev/null || true
php artisan event:cache                   2>/dev/null || true

echo "Blood Link is starting on port ${PORT}"
exec apache2-foreground
