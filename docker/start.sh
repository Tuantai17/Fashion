#!/bin/sh
set -e

echo "Running database migrations..."
php artisan migrate --force || echo "Migrations skipped or already up-to-date."

# Sau khi có full source + vendor mới chạy các composer scripts còn lại
echo "Running composer post-autoload scripts (package:discover)..."
php artisan package:discover --ansi || true

echo "Starting services (nginx + php-fpm) ..."
exec /entrypoint supervisord
