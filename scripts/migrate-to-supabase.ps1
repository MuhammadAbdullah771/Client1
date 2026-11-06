# Migrates data from legacy MySQL to Supabase PostgreSQL (run from project root).
# Usage: .\scripts\migrate-to-supabase.ps1

$Root = Split-Path -Parent (Split-Path -Parent $MyInvocation.MyCommand.Path)
Set-Location $Root

Write-Host "==> MySQL -> Supabase migration"
php artisan config:clear
php artisan db:migrate-to-supabase --fresh

Write-Host ""
Write-Host "Next steps:"
Write-Host "  1. Create admin user in Supabase Dashboard -> Authentication -> Users"
Write-Host "  2. Set SUPABASE_AUTH_ENABLED=true and SUPABASE_ADMIN_EMAILS in .env"
Write-Host "  3. php artisan config:cache"
