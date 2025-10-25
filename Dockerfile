# ---- Stage 1: build frontend assets (Vite) ----
FROM node:20-alpine AS assets
WORKDIR /app

# copy manifest và cài deps
COPY package.json package-lock.json* ./
# dùng legacy-peer-deps để tránh xung đột peer
RUN npm ci --no-audit --fund=false --legacy-peer-deps

# copy code FE cần cho build
COPY vite.config.js postcss.config.js tailwind.config.js* ./
COPY resources ./resources

# build -> mặc định laravel-vite-plugin xuất ra public/build
RUN npm run build

# ---- Stage 2: install PHP dependencies (Composer) ----
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# ---- Stage 3: runtime (PHP-FPM + Nginx) ----
FROM webdevops/php-nginx:8.2-alpine
WORKDIR /app

# công cụ bổ sung
RUN apk add --no-cache git bash

# cấu hình document root Laravel
ENV WEB_DOCUMENT_ROOT=/app/public \
    APP_ENV=production \
    PHP_DISPLAY_ERRORS=0

# copy toàn project
COPY . .

# copy vendor và asset đã build từ các stage trước
COPY --from=vendor /app/vendor /app/vendor
COPY --from=assets /app/public /app/public

# chuẩn bị storage, cache, symlink
RUN mkdir -p storage/framework/{cache,sessions,views} \
    && chown -R application:application /app

USER application

# clear cache an toàn khi build
RUN php artisan config:clear || true \
    && php artisan route:clear || true \
    && php artisan view:clear || true \
    && php artisan storage:link || true

# script start: migrate rồi chạy supervisord (nginx+php-fpm)
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh
CMD ["/start.sh"]
