# ---- Stage 1: build frontend assets (Vite) ----
FROM node:20-alpine AS assets
WORKDIR /app

COPY package.json package-lock.json* ./
RUN npm ci --no-audit --fund=false --legacy-peer-deps

COPY vite.config.js ./
COPY resources ./resources
RUN npm run build


# ---- Stage 2: install PHP dependencies (Composer) ----
FROM composer:2 AS vendor
WORKDIR /app

# Copy full project để có artisan
COPY . .
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader \
    || true


# ---- Stage 3: runtime (PHP-FPM + Nginx) ----
FROM webdevops/php-nginx:8.2-alpine
WORKDIR /app

RUN apk add --no-cache git bash

ENV WEB_DOCUMENT_ROOT=/app/public \
    APP_ENV=production \
    PHP_DISPLAY_ERRORS=0

# Copy toàn bộ project
COPY . .

# Copy vendor & asset đã build
COPY --from=vendor /app/vendor /app/vendor
COPY --from=assets /app/public /app/public

# Copy cấu hình nginx custom (nếu có)
COPY docker/nginx.conf /etc/nginx/nginx.conf

# ✅ Copy start.sh & cấp quyền khi vẫn là root
COPY docker/start.sh /start.sh
RUN chmod 755 /start.sh

# Chuẩn bị storage, cache...
RUN mkdir -p storage/framework/{cache,sessions,views} \
    && chown -R application:application /app

# Chuyển sang user không root
USER application

# Clear cache Laravel
RUN php artisan config:clear || true \
    && php artisan route:clear || true \
    && php artisan view:clear || true \
    && php artisan storage:link || true

# Chạy script start
CMD ["/start.sh"]
