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
COPY --from=vendor  /app/vendor  /app/vendor
COPY --from=assets  /app/public  /app/public

# start.sh có quyền thực thi và đúng owner NGAY khi build
COPY --chown=application:application --chmod=0755 docker/start.sh /start.sh

RUN mkdir -p storage/framework/{cache,sessions,views} storage/logs \
    && chown -R application:application /app

# chạy không-root
USER application

# dọn cache an toàn lúc build
RUN php artisan config:clear  || true \
    && php artisan route:clear   || true \
    && php artisan view:clear    || true \
    && php artisan storage:link  || true

CMD ["/start.sh"]
