#!/bin/sh
set -e

echo "Running database migrations..."
php artisan migrate --force || echo "Migrations skipped or already up-to-date."

echo "Running package discovery..."
php artisan package:discover --ansi || true

echo "Starting services (nginx + php-fpm)..."
exec /entrypoint supervisord
