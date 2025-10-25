#!/bin/sh
set -e

echo "Running database migrations..."
php artisan migrate --force || echo "Migrations skipped or already up-to-date."

echo "Starting services (nginx + php-fpm)..."
exec /entrypoint supervisord
