#!/bin/sh
set -e

echo "Running database migrations..."
php artisan migrate --force || echo "Migrations skipped or already up-to-date."

echo "Starting services (nginx + php-fpm) ..."
# chạy supervisord ở foreground, không đổi user
exec /usr/bin/supervisord -n -c /opt/docker/etc/supervisor.conf
