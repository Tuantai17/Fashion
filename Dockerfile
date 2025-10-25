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
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# ---- Stage 3: runtime ----
FROM webdevops/php-nginx:8.2-alpine
WORKDIR /app

ENV WEB_DOCUMENT_ROOT=/app/public \
    APP_ENV=production \
    PHP_DISPLAY_ERRORS=0

COPY . .
COPY --from=vendor /app/vendor /app/vendor
COPY --from=assets /app/public /app/public

# tạo thư mục runtime, cấp quyền
RUN mkdir -p storage/framework/{cache,sessions,views} \
    && mkdir -p storage/logs \
    && chown -R application:application /app

# KHÔNG đổi sang root
USER application

# clear caches
RUN php artisan config:clear || true \
    && php artisan route:clear || true \
    && php artisan view:clear || true \
    && php artisan storage:link || true

# copy start script
COPY docker/start.sh /start.sh

# KHÔNG chmod ở đây – vì bạn không có quyền root!
# start script gọi entrypoint sẵn có của webdevops
CMD ["/start.sh"]
