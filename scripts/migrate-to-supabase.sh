#!/usr/bin/env bash
set -euo pipefail

# Migrates data from legacy MySQL to Supabase PostgreSQL.
# Prerequisites:
#   1. Supabase project created
#   2. .env has DB_CONNECTION=pgsql + Supabase DB credentials
#   3. MYSQL_SOURCE_* points at your old cPanel MySQL database
#
# Usage: bash scripts/migrate-to-supabase.sh

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT"

echo "==> MySQL → Supabase migration"
php artisan config:clear
php artisan db:migrate-to-supabase --fresh

echo ""
echo "Next steps:"
echo "  1. Create admin user in Supabase Dashboard → Authentication → Users"
echo "  2. Set SUPABASE_AUTH_ENABLED=true and SUPABASE_ADMIN_EMAILS in .env"
echo "  3. php artisan config:cache"
