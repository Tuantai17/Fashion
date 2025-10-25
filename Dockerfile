# ------- Stage 1: composer (skip scripts) -------
FROM composer:2 AS vendor
ENV COMPOSER_ALLOW_SUPERUSER=1
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts
COPY . .

# ------- Stage 2: build Vite assets -------
FROM node:20 AS assets
WORKDIR /app
COPY package.json package-lock.json* yarn.lock* pnpm-lock.yaml* ./
RUN if [ -f package-lock.json ]; then npm ci; \
    elif [ -f yarn.lock ]; then yarn install --frozen-lockfile; \
    elif [ -f pnpm-lock.yaml ]; then corepack enable && pnpm i --frozen-lockfile; \
    else npm i; fi
COPY resources ./resources
COPY vite.config.* ./
COPY postcss.config.* ./
COPY tailwind.config.* ./
RUN npm run build

# ------- Stage 3: runtime (Apache + PHP) -------
FROM php:8.3-apache
RUN docker-php-ext-install pdo_mysql && a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/000-default.conf /etc/apache2/apache2.conf

WORKDIR /var/www/html
COPY --from=vendor /app /var/www/html
# 👇 Quan trọng: copy thành quả build vào đúng chỗ
COPY --from=assets /app/public/build /var/www/html/public/build
RUN chown -R www-data:www-data storage bootstrap/cache public/build
