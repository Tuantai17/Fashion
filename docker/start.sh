#!/usr/bin/env sh
set -e

# Link storage (bỏ qua nếu đã có)
php artisan storage:link 2>/dev/null || true

# Migrate nếu có DB (không fail nếu thiếu env)
php artisan migrate --force 2>/dev/null || true

# Có thể build cache khi APP_KEY sẵn sàng
php artisan config:clear 2>/dev/null || true
php artisan route:clear  2>/dev/null || true
php artisan view:clear   2>/dev/null || true

# Chạy PHP built-in server (phù hợp Render Free, không cần root)
# Render cung cấp biến $PORT, dùng mặc định 8080 nếu chưa có (local)
PORT="${PORT:-8080}"
exec php -S 0.0.0.0:$PORT -t public public/index.php
