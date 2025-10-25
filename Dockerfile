# ---- Stage 1: build frontend assets ----
FROM node:20-alpine AS assets
WORKDIR /app

COPY package.json package-lock.json* ./
RUN npm ci --no-audit --fund=false --legacy-peer-deps

COPY vite.config.js ./
# COPY tailwind.config.js ./
# COPY postcss.config.js ./
COPY resources ./resources

RUN npm run build

# ---- Stage 2: composer dependencies ----
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
# Lưu ý: --no-scripts để tránh chạy post-autoload ở bước build
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# ---- Stage 3: runtime ----
FROM webdevops/php-nginx:8.2-alpine
WORKDIR /app

ENV WEB_DOCUMENT_ROOT=/app/public \
    APP_ENV=production \
    PHP_DISPLAY_ERRORS=0

# (Vẫn đang là user mặc định của image - root)
COPY . .
COPY --from=vendor /app/vendor /app/vendor
COPY --from=assets /app/public /app/public

# Copy start script kèm quyền và owner ngay khi build (BuildKit)
# Render hỗ trợ BuildKit, nên có thể dùng --chmod/--chown
COPY --chown=application:application --chmod=0755 docker/start.sh /start.sh

# Chuẩn bị thư mục runtime và phân quyền
RUN mkdir -p storage/framework/{cache,sessions,views} storage/logs \
    && chown -R application:application /app

# Từ đây chạy app với user không-root
USER application

# Clear cache/symlink an toàn lúc build (không fail build)
RUN php artisan config:clear || true \
    && php artisan route:clear  || true \
    && php artisan view:clear   || true \
    && php artisan storage:link || true

# Khởi động (start.sh sẽ gọi /entrypoint supervisord)
CMD ["/start.sh"]
