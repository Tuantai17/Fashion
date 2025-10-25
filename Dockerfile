# ---- Stage 1: build frontend assets (Vite) ----
FROM node:20-alpine AS assets
WORKDIR /app

# 1) Cài deps theo lockfile (ổn định)
COPY package.json package-lock.json* ./
RUN npm ci --no-audit --fund=false --legacy-peer-deps

# 2) Copy file cấu hình chắc chắn có + mã nguồn FE
COPY vite.config.js ./
# Nếu bạn có 2 file dưới thì bỏ comment để copy:
# COPY tailwind.config.js ./
# KHÔNG dùng postcss.config.js khi Tailwind v4 + @tailwindcss/vite

COPY resources ./resources

# 3) Build -> laravel-vite-plugin xuất ra public/build
RUN npm run build


# ---- Stage 2: install PHP dependencies (Composer) ----
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader


# ---- Stage 3: runtime (PHP-FPM + Nginx) ----
FROM webdevops/php-nginx:8.2-alpine
WORKDIR /app

# Công cụ bổ sung
RUN apk add --no-cache git bash

# Laravel document root
ENV WEB_DOCUMENT_ROOT=/app/public \
    APP_ENV=production \
    PHP_DISPLAY_ERRORS=0

# Copy toàn project (đã loại bỏ node_modules/vendor qua .dockerignore)
COPY . .

# Copy vendor & asset build từ các stage trước
COPY --from=vendor /app/vendor /app/vendor
COPY --from=assets /app/public /app/public

# Quyền & chuẩn bị thư mục runtime
RUN mkdir -p storage/framework/{cache,sessions,views} \
    && chown -R application:application /app

USER application

# Clear cache an toàn khi build
RUN php artisan config:clear || true \
    && php artisan route:clear || true \
    && php artisan view:clear || true \
    && php artisan storage:link || true

# Start script: migrate rồi chạy nginx+php-fpm
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh
CMD ["/start.sh"]
