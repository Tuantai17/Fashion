# ---- Stage 1: build assets ----
FROM node:20-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json* ./
RUN npm ci --no-audit --fund=false --legacy-peer-deps
COPY vite.config.js ./
COPY resources ./resources
RUN npm run build

# ---- Stage 2: composer vendor ----
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# ---- Stage 3: runtime ----
FROM webdevops/php-nginx:8.2-alpine
WORKDIR /app

ENV WEB_DOCUMENT_ROOT=/app/public \
    APP_ENV=production \
    PHP_DISPLAY_ERRORS=0

# copy code, vendor, assets, scripts
COPY . .
COPY --from=vendor /app/vendor /app/vendor
COPY --from=assets /app/public /app/public

# chuẩn bị thư mục runtime
RUN mkdir -p storage/framework/{cache,sessions,views} \
    && chown -R application:application /app

# chạy bằng user mặc định của image (application)
USER application

# dọn cache an toàn
RUN php artisan config:clear || true \
 && php artisan route:clear || true \
 && php artisan view:clear  || true

# start script
CMD ["/bin/sh","/start.sh"]
