#!/bin/bash
# Jalankan otomatis setelah git pull di aaPanel (Git → Hook / Execute command).
set -euo pipefail

cd "$(dirname "$0")/.."

WWW_USER="${WWW_USER:-www}"

mkdir -p \
  storage/framework/cache/data \
  storage/framework/sessions \
  storage/framework/views \
  storage/logs \
  bootstrap/cache

chmod -R ug+rwx storage bootstrap/cache

if id "$WWW_USER" >/dev/null 2>&1; then
  chown -R "${WWW_USER}:${WWW_USER}" storage bootstrap/cache
fi

php artisan optimize:clear
php artisan view:clear
php artisan migrate --force
