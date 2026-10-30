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

# SQLite: the database file is git-ignored, so it does not exist in the image.
# Create it before migrating, otherwise PDO throws "database does not exist".
# The whole directory is handed to www-data (not just the file) because SQLite
# also writes -wal/-shm sidecars there, and www-data must be able to replace
# the root-owned ones that `artisan migrate` creates below.
if [ "${DB_CONNECTION:-sqlite}" = "sqlite" ]; then
    DB_FILE="${DB_DATABASE:-/var/www/html/database/database.sqlite}"
    case "${DB_FILE}" in
        /*) ;;
        *) DB_FILE="/var/www/html/${DB_FILE}" ;;
    esac
    DB_DIR="$(dirname "${DB_FILE}")"

    mkdir -p "${DB_DIR}"
    [ -f "${DB_FILE}" ] || : > "${DB_FILE}"
    chown -R www-data:www-data "${DB_DIR}" 2>/dev/null || true
    chmod 775 "${DB_DIR}" 2>/dev/null || true

    # Keep the value absolute for the artisan calls that follow.
    DB_DATABASE="${DB_FILE}"
    export DB_DATABASE
fi

# Generate an app key if one was not provided
if [ -z "${APP_KEY:-}" ]; then
    php artisan key:generate --force
fi

# Run pending migrations (best-effort: never block the container from starting)
php artisan migrate --force --no-interaction || echo "warn: migrate failed (will retry next deploy)"

# Migrating as root can leave root-owned -wal/-shm files behind; hand the
# directory back to the web user so Apache can write to it.
if [ -n "${DB_DIR:-}" ]; then
    chown -R www-data:www-data "${DB_DIR}" 2>/dev/null || true
fi

# Warm the caches now that the environment is available
php artisan config:cache                      2>/dev/null || true
php artisan route:cache                       2>/dev/null || true
php artisan view:cache                        2>/dev/null || true
php artisan event:cache                       2>/dev/null || true

echo "Blood Link is starting on port ${PORT}"
exec apache2-foreground
