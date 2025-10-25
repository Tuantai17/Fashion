# ---- Stage 1: build Vite assets ----
FROM node:20-alpine AS assets
WORKDIR /app

COPY package.json package-lock.json* ./
RUN npm ci --no-audit --fund=false --legacy-peer-deps

COPY vite.config.js ./
# (Chỉ copy 2 file dưới nếu chúng tồn tại trong repo)
# COPY tailwind.config.js ./
# COPY postcss.config.js ./

COPY resources ./resources
RUN npm run build
# laravel-vite-plugin output -> /public/build

# ---- Stage 2: install PHP dependencies (Composer) ----
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
# ⛔️ Không chạy scripts ở stage này (chưa có file artisan)
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# ---- Stage 3: runtime (Nginx + PHP-FPM) ----
FROM webdevops/php-nginx:8.2-alpine
WORKDIR /app

# Image này mặc định user 'application' (non-root) -> phù hợp Render
ENV WEB_DOCUMENT_ROOT=/app/public \
    APP_ENV=production \
    PHP_DISPLAY_ERRORS=0

# Copy toàn bộ mã nguồn
COPY . .

# Copy vendor & assets đã build
COPY --from=vendor /app/vendor /app/vendor
COPY --from=assets /app/public /app/public

# Chuẩn bị storage, cache, quyền
RUN mkdir -p storage/framework/{cache,sessions,views} \
    && mkdir -p storage/logs \
    && chown -R application:application /app

USER application

# Clear caches an toàn lúc build (không fail nếu artisan chưa sẵn sàng)
RUN php artisan config:clear || true \
    && php artisan route:clear || true \
    && php artisan view:clear || true \
    && php artisan storage:link || true

# Script start: migrate + chạy dịch vụ (nginx + php-fpm)
COPY docker/start.sh /start.sh
# Khi build trong Linux, Render giữ nguyên quyền; nếu bạn dev Windows hãy đảm bảo đã chmod +x (mục 3).
CMD ["/start.sh"]
