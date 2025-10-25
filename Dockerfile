# ---- Stage 1: build frontend assets ----
FROM node:20-alpine AS assets
WORKDIR /app

COPY package.json package-lock.json* ./
RUN npm ci --no-audit --fund=false --legacy-peer-deps

COPY vite.config.js ./
# COPY tailwind.config.js ./
# COPY postcss.config.js ./
COPY resources ./resources

RUN npm run build   # laravel-vite-plugin -> public/build

# ---- Stage 2: composer dependencies ----
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
# Không trigger scripts lúc build để tránh chạy artisan trong môi trường build
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# ---- Stage 3: runtime ----
FROM webdevops/php-nginx:8.2-alpine
WORKDIR /app

ENV WEB_DOCUMENT_ROOT=/app/public \
    APP_ENV=production \
    PHP_DISPLAY_ERRORS=0

# *** TẠM THỜI dùng root để copy/chmod file, set quyền thư mục ***
USER root

# Copy mã nguồn + vendor + assets
COPY . .
COPY --from=vendor /app/vendor /app/vendor
COPY --from=assets /app/public /app/public

# Thư mục runtime & quyền
RUN mkdir -p storage/framework/{cache,sessions,views} storage/logs \
    && chown -R application:application /app

# Start script
COPY docker/start.sh /start.sh
# Chuẩn hoá kết thúc dòng (LF), gán quyền thực thi
RUN sed -i 's/\r$//' /start.sh && chmod +x /start.sh

# *** CHUYỂN SANG USER application cho runtime ***
USER application

# Clear caches an toàn
RUN php artisan config:clear  || true \
    && php artisan route:clear   || true \
    && php artisan view:clear    || true \
    && php artisan storage:link  || true

# Không override entrypoint; chỉ chạy start.sh
CMD ["/start.sh"]
