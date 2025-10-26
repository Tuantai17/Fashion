#!/usr/bin/env sh
set -euo pipefail

echo "==> Booting container…"
echo "PWD: $(pwd)"
echo "PHP version:"
php -v || true

echo "Enabled PHP extensions:"
php -m || true

echo "APP_ENV=${APP_ENV:-}"
echo "APP_URL=${APP_URL:-}"
echo "PORT from Render: ${PORT:-8080}"

echo "==> Laravel prep…"
php artisan --version || true

echo "[1/5] storage:link"
php artisan storage:link 2>/dev/null || true

echo "[2/5] migrate --force"
php artisan migrate --force 2>/dev/null || true

echo "[3/5] config:clear"
php artisan config:clear 2>/dev/null || true

echo "[4/5] route:clear"
php artisan route:clear 2>/dev/null || true

echo "[5/5] view:clear"
php artisan view:clear 2>/dev/null || true

PORT="${PORT:-8080}"
echo "==> Starting PHP built-in server on 0.0.0.0:${PORT}"
exec php -S 0.0.0.0:$PORT -t public public/index.php

