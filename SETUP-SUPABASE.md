# 9Associates — Supabase & Hosting Setup

## Why the site was failing on hosting

1. **Broken `.env` formatting** — DB keys had a leading space (` DB_CONNECTION=mysql`), so Laravel could not read database credentials.
2. **Document root** — The app must be served from the `public/` folder. A root `.htaccess` is included to redirect requests when the host points at the project root.
3. **Missing `Admin` model** — `config/auth.php` referenced `App\Models\Admin` but the class did not exist.
4. **Debug mode** — `APP_DEBUG=true` on production exposes errors; set `APP_DEBUG=false`.
5. **Hidden `.env` on cPanel** — Use `hosting.env.example` (visible filename), then rename to `.env`.

---

## Step 1 — Create Supabase project

1. Go to [supabase.com](https://supabase.com) → New project.
2. Note these from **Project Settings → API**:
   - Project URL → `SUPABASE_URL`
   - `anon` key → `SUPABASE_ANON_KEY`
   - `service_role` key → `SUPABASE_SERVICE_ROLE_KEY` (server only, never expose in frontend)
3. From **Project Settings → Database**:
   - Host, database, user, password → `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
   - Connection string → optional `DB_URL`

---

## Step 2 — Configure `.env` on hosting

```bash
cp hosting.env.example .env
nano .env   # or edit in cPanel File Manager (enable "Show Hidden Files")
```

Set at minimum:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://9associates.com
DB_CONNECTION=pgsql
DB_HOST=db.YOUR_REF.supabase.co
DB_PASSWORD=...
DB_SSLMODE=require
SUPABASE_URL=https://YOUR_REF.supabase.co
SUPABASE_ANON_KEY=...
SUPABASE_SERVICE_ROLE_KEY=...
SUPABASE_AUTH_ENABLED=true
SUPABASE_ADMIN_EMAILS=admin@9associates.com
```

Generate app key:

```bash
php artisan key:generate
```

---

## Step 3 — Deploy on cPanel

```bash
bash scripts/setup-cpanel.sh
```

Or manually:

```bash
composer install --optimize-autoloader --no-dev
npm ci && npm run build
php artisan storage:link
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**Document root** must be `public_html/public` (or symlink `public` → `public_html`).

---

## Step 4 — Copy MySQL data to Supabase

While still able to reach your old cPanel MySQL database, set source credentials:

```env
MYSQL_SOURCE_HOST=127.0.0.1
MYSQL_SOURCE_DATABASE=associat_9associates
MYSQL_SOURCE_USERNAME=associat_9associates
MYSQL_SOURCE_PASSWORD=your_old_password
```

Then run:

```bash
php artisan config:clear
php artisan db:migrate-to-supabase --fresh
```

Windows:

```powershell
.\scripts\migrate-to-supabase.ps1
```

This will:

- Run migrations on Supabase
- Copy all tables from MySQL
- Reset PostgreSQL ID sequences
- Copy `users` into `admins` for admin login compatibility

---

## Step 5 — Admin login via Supabase Auth

1. Supabase Dashboard → **Authentication → Users** → Add user  
   - Email must match `SUPABASE_ADMIN_EMAILS` in `.env`
2. Set a strong password (managed in Supabase, not in Laravel DB)
3. Visit: `https://9associates.com/{ADMIN_SECRET_PATH}/`
4. Log in with the Supabase user email/password

To disable Supabase Auth and use local passwords instead:

```env
SUPABASE_AUTH_ENABLED=false
```

Then seed a local admin:

```bash
php artisan db:seed --class=AdminSeeder
```

---

## Step 6 — Verify

```bash
php artisan db:verify
php artisan config:cache
```

Open `https://9associates.com/up` — should return `{"status":"ok"}`.

---

## Security reminders

- Rotate DB and mail passwords if they were ever committed or shared.
- Change `ADMIN_SECRET_PATH` from the default.
- Never commit `.env` to git.
- Keep `SUPABASE_SERVICE_ROLE_KEY` only on the server.
