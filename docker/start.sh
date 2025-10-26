#!/usr/bin/env sh
set -e
php artisan storage:link 2>/dev/null || true
php artisan migrate --force 2>/dev/null || true
php artisan config:clear 2>/dev/null || true
php artisan route:clear  2>/dev/null || true
php artisan view:clear   2>/dev/null || true
PORT="${PORT:-8080}"
exec php -S 0.0.0.0:$PORT -t public public/index.php
