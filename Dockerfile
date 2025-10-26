# ---- Stage 1: build frontend assets ----
FROM node:20-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json* ./
RUN npm ci --no-audit --fund=false --legacy-peer-deps
COPY vite.config.js ./
COPY resources ./resources
RUN npm run build

# ---- Stage 2: composer dependencies ----
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# ---- Stage 3: runtime ----
FROM php:8.2-cli-alpine

RUN apk add --no-cache libpng-dev oniguruma-dev libzip-dev zip unzip \
    && docker-php-ext-install pdo_mysql mbstring gd zip opcache

WORKDIR /app
ENV APP_ENV=production \
    PHP_DISPLAY_ERRORS=0

# Copy mã nguồn + vendor + assets
COPY . .
COPY --from=vendor /app/vendor /app/vendor
COPY --from=assets /app/public /app/public

# Chuẩn bị quyền ghi
RUN mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache

# >>> COPY start.sh khi còn root và đặt ở PATH
COPY docker/start.sh /usr/local/bin/start.sh
RUN sed -i 's/\r$//' /usr/local/bin/start.sh || true \
    && chmod +x /usr/local/bin/start.sh

# Tạo user thường và gán quyền mã nguồn
RUN adduser -D -u 10001 appuser \
    && chown -R appuser:appuser /app
USER appuser

# Chạy PHP server theo PORT của Render
CMD ["start.sh"]
