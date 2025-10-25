#!/usr/bin/env bash
set -e

cd /var/www/html

echo "[entrypoint] waiting for database ${DB_HOST}:${DB_PORT:-3306} ..."
# chờ DB sẵn sàng (dùng PHP PDO để thử kết nối)
php -r '
$h=getenv("DB_HOST"); $p=getenv("DB_PORT")?:3306; $d=getenv("DB_DATABASE"); $u=getenv("DB_USERNAME"); $pw=getenv("DB_PASSWORD");
$dsn="mysql:host=$h;port=$p;dbname=$d;charset=utf8mb4";
$ok=false; for($i=0;$i<60;$i++){ try{ new PDO($dsn,$u,$pw,[PDO::ATTR_TIMEOUT=>2]); $ok=true; break; }catch(Exception $e){ sleep(2); }}
if(!$ok){ fwrite(STDERR,"DB not ready after wait\n"); } else { echo "DB ready\n"; }
';

# key app (không lỗi nếu đã có)
php artisan key:generate --force || true

# liên kết & dọn cache
php artisan storage:link || true
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true
php artisan view:clear || true

# migrate (không dừng container nếu lỗi nhỏ)
php artisan migrate --force || true

echo "[entrypoint] start services..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
