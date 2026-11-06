#!/usr/bin/env bash
set -euo pipefail

# Run from project root on cPanel terminal (or SSH).
# Usage: bash scripts/setup-cpanel.sh

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT"

echo "==> 9Associates cPanel setup"
echo "Project root: $ROOT"

if [ ! -f .env ]; then
  if [ -f hosting.env.example ]; then
    cp hosting.env.example .env
    echo "Created .env from hosting.env.example — edit it before continuing."
  else
    cp .env.example .env
    echo "Created .env from .env.example — edit it before continuing."
  fi
fi

if ! grep -q '^APP_KEY=base64:' .env 2>/dev/null; then
  php artisan key:generate --force
fi

composer install --optimize-autoloader --no-dev --no-interaction

if [ -f package.json ]; then
  npm ci --omit=dev 2>/dev/null || npm install --omit=dev
  npm run build
fi

php artisan storage:link 2>/dev/null || true
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

chmod -R 775 storage bootstrap/cache 2>/dev/null || true

echo ""
echo "Done. Ensure your domain document root points to: $ROOT/public"
echo "Admin URL: $(grep '^APP_URL=' .env | cut -d= -f2-)/$(grep '^ADMIN_SECRET_PATH=' .env | cut -d= -f2-)"
