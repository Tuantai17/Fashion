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


# ---- Stage 3: runtime ----
FROM webdevops/php-nginx:8.2-alpine
WORKDIR /app

# công cụ nhỏ
RUN apk add --no-cache bash

# đặt document root cho webdevops image (không cần port 80)
ENV WEB_DOCUMENT_ROOT=/app/public \
    APP_ENV=production \
    PHP_DISPLAY_ERRORS=0

# copy toàn bộ mã nguồn (đã có .dockerignore lọc vendor/node_modules)
COPY . .

# copy vendor và assets build
COPY --from=vendor /app/vendor /app/vendor
COPY --from=assets /app/public /app/public

# dùng cấu hình nginx của mình (lắng nghe ${PORT})
COPY docker/nginx.conf /etc/nginx/nginx.conf

# phân quyền runtime cho user ứng dụng (không root)
RUN mkdir -p storage/framework/{cache,sessions,views} \
    && chown -R application:application /app

USER application

# clear cache an toàn khi build
RUN php artisan config:clear || true \
    && php artisan route:clear  || true \
    && php artisan view:clear   || true \
    && php artisan storage:link || true

# script khởi động (không gọi /entrypoint để tránh switch user)
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

CMD ["/start.sh"]
