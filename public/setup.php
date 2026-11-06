<?php
/**
 * 9Associates — One-Click Live Server Setup
 * Upload inside public_html/, open in browser, delete when done.
 * Password: 9assoc2024
 */

define('SETUP_PASS', '9assoc2024');
session_start();
$authed = ($_SESSION['sa'] ?? '') === SETUP_PASS;

if (!$authed && $_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['p'] ?? '') === SETUP_PASS) {
    $_SESSION['sa'] = SETUP_PASS;
    $authed = true;
}

// Find app root
function findRoot(): ?string {
    if (is_dir(__DIR__ . '/../vendor'))              return realpath(__DIR__ . '/..');
    if (is_dir(__DIR__ . '/../9associates/vendor'))  return realpath(__DIR__ . '/../9associates');
    if (is_dir(__DIR__ . '/9associates/vendor'))     return realpath(__DIR__ . '/9associates');
    // No vendor — try without vendor check
    if (is_dir(__DIR__ . '/../9associates'))         return realpath(__DIR__ . '/../9associates');
    if (is_dir(__DIR__ . '/9associates'))            return realpath(__DIR__ . '/9associates');
    return null;
}

$appRoot = findRoot();
$results = [];

if ($authed && isset($_POST['action'])) {
    $a = $_POST['action'];

    if ($a === 'setup' && $appRoot) {
        // 1. Write .env
        $envContent = 'APP_NAME="9Associates"
APP_ENV=production
APP_KEY=base64:7uVrO2abiPJsd7wTaB7wBfSacmX0Ul6CBE9NoU/C9ak=
APP_DEBUG=false
APP_URL=https://9associates.com
ADMIN_SECRET_PATH=secure-admin-9a2024

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US
APP_MAINTENANCE_DRIVER=file
BCRYPT_ROUNDS=12
LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=associat_9associates
DB_USERNAME=associat_9associates
DB_PASSWORD=Scammer91@

SESSION_DRIVER=database
SESSION_LIFETIME=480
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=
SESSION_SECURE_COOKIE=false
SESSION_SAME_SITE=lax

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
CACHE_STORE=file

MAIL_MAILER=smtp
MAIL_HOST=mail.9associates.com
MAIL_PORT=465
MAIL_SCHEME=smtps
MAIL_USERNAME=contact@9associates.com
MAIL_PASSWORD=Waqas@74.
MAIL_FROM_ADDRESS=contact@9associates.com
MAIL_FROM_NAME="9Associates"
CONTACT_FORM_EMAIL=contact@9associates.com
IT_SUPPORT_EMAIL=contact@9associates.com
JOB_NOTIFICATION_EMAIL=contact@9associates.com

GEMINI_API_KEY=
GEMINI_MODEL=gemini-2.0-flash

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"
';
        $w = @file_put_contents("$appRoot/.env", $envContent);
        $results[] = [$w !== false, '.env written to ' . $appRoot];

        // 2. Fix permissions
        $dirs = [
            "$appRoot/storage", "$appRoot/storage/app", "$appRoot/storage/app/public",
            "$appRoot/storage/framework", "$appRoot/storage/framework/cache",
            "$appRoot/storage/framework/cache/data", "$appRoot/storage/framework/sessions",
            "$appRoot/storage/framework/views", "$appRoot/storage/logs", "$appRoot/bootstrap/cache",
        ];
        foreach ($dirs as $d) { if (!is_dir($d)) @mkdir($d,0775,true); @chmod($d,0775); }
        $results[] = [true, 'Storage permissions set to 775'];

        // 3. Clear all caches
        $cleared = 0;
        foreach (glob("$appRoot/storage/framework/views/*.php") ?: [] as $f)  { @unlink($f); $cleared++; }
        foreach (glob("$appRoot/storage/framework/sessions/*") ?: [] as $f)   { if(is_file($f)) { @unlink($f); $cleared++; } }
        $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator("$appRoot/storage/framework/cache", FilesystemIterator::SKIP_DOTS));
        foreach ($it as $f) { if($f->isFile()) { @unlink($f->getPathname()); $cleared++; } }
        foreach (['config.php','services.php','packages.php','events.php'] as $cf) {
            $p = "$appRoot/bootstrap/cache/$cf"; if(file_exists($p)){@unlink($p);$cleared++;}
        }
        foreach (glob("$appRoot/bootstrap/cache/routes*.php") ?: [] as $f) { @unlink($f); $cleared++; }
        $results[] = [true, "All caches cleared ($cleared files)"];

        // 4. Test DB + ensure sessions table
        try {
            $pdo = new PDO('mysql:host=127.0.0.1;dbname=associat_9associates;charset=utf8',
                'associat_9associates', 'Scammer91@',
                [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT=>5]);
            $results[] = [true, 'Database connected: associat_9associates'];

            $has = $pdo->query("SHOW TABLES LIKE 'sessions'")->rowCount() > 0;
            if (!$has) {
                $pdo->exec("CREATE TABLE IF NOT EXISTS `sessions` (`id` varchar(255) NOT NULL,`user_id` bigint unsigned DEFAULT NULL,`ip_address` varchar(45) DEFAULT NULL,`user_agent` text,`payload` longtext NOT NULL,`last_activity` int NOT NULL,PRIMARY KEY (`id`),KEY `sessions_user_id_index`(`user_id`),KEY `sessions_last_activity_index`(`last_activity`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $results[] = [true, 'sessions table created in database'];
            } else {
                $results[] = [true, 'sessions table exists ✓'];
            }
        } catch (Exception $e) {
            $results[] = [false, 'DB error: ' . $e->getMessage()];
        }

        // 5. Write test
        $tf = "$appRoot/storage/framework/sessions/.wtest";
        $wOk = @file_put_contents($tf, 'ok') !== false;
        if ($wOk) @unlink($tf);
        $results[] = [$wOk, 'Storage write test: ' . ($wOk ? 'SUCCESS' : 'FAILED — set storage/ to 775 in cPanel')];
    }

    if ($a === 'delete') {
        @session_destroy();
        @unlink(__FILE__);
        echo '<!DOCTYPE html><html><head><title>Deleted</title></head><body style="font-family:sans-serif;background:#0d141b;color:#6ee7b7;padding:40px;text-align:center"><h2>setup.php deleted.</h2><p style="color:#94a3b8;margin-top:12px">Your site is live. <a href="/" style="color:#137fec">Go to homepage</a></p></body></html>';
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>9Associates — Setup</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:#0d141b;color:#e2e8f0;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px}
.card{background:#1e293b;border:1px solid #334155;border-radius:16px;padding:36px;width:100%;max-width:560px}
.logo{font-size:22px;font-weight:900;color:#137fec;margin-bottom:4px}
.sub{font-size:12px;color:#64748b;margin-bottom:28px}
h3{font-size:16px;font-weight:700;color:#f1f5f9;margin-bottom:18px}
input[type=password]{width:100%;padding:12px 16px;background:#0f172a;border:1px solid #334155;border-radius:10px;color:#f1f5f9;font-size:15px;outline:none;margin-bottom:14px}
input:focus{border-color:#137fec}
.btn{display:inline-flex;align-items:center;justify-content:center;padding:12px 24px;border-radius:10px;font-size:14px;font-weight:700;cursor:pointer;border:none;width:100%;margin-bottom:10px}
.btn-blue{background:#137fec;color:#fff}.btn-blue:hover{background:#0e6fd4}
.btn-red{background:#dc2626;color:#fff}.btn-red:hover{background:#b91c1c}
.r{padding:10px 14px;border-radius:7px;font-size:13px;margin-bottom:7px;display:flex;align-items:flex-start;gap:10px}
.ok{background:#064e3b;border:1px solid #065f46;color:#6ee7b7}
.fail{background:#450a0a;border:1px solid #7f1d1d;color:#fca5a5;font-weight:bold}
.warn{background:#1e293b;border:1px solid #334155;color:#94a3b8}
.ico{flex-shrink:0;font-weight:900}
.checks{margin-bottom:20px}
.div{border-top:1px solid #334155;margin:20px 0}
.tip{background:#1e3a5f;border:1px solid #1d4ed8;color:#93c5fd;padding:14px 16px;border-radius:10px;font-size:13px;line-height:1.8;margin-bottom:18px}
.root{font-family:monospace;font-size:11px;color:#64748b;margin-bottom:20px}
</style>
</head>
<body>
<div class="card">
  <div class="logo">9Associates</div>
  <div class="sub">One-click server setup — delete after use</div>

  <?php if (!$authed): ?>
  <h3>Enter Setup Password</h3>
  <form method="POST">
    <input type="password" name="p" placeholder="Password..." autofocus>
    <button type="submit" class="btn btn-blue">Unlock</button>
  </form>

  <?php else: ?>

  <?php if ($appRoot): ?>
  <div class="root">App root: <?= htmlspecialchars($appRoot) ?></div>
  <?php endif; ?>

  <?php if (!empty($results)): ?>
  <div class="checks">
    <?php foreach ($results as [$ok, $msg]): ?>
    <div class="r <?= $ok ? 'ok' : 'fail' ?>">
      <span class="ico"><?= $ok ? '✓' : '✕' ?></span>
      <span><?= htmlspecialchars($msg) ?></span>
    </div>
    <?php endforeach; ?>
  </div>
  <?php if (!in_array(false, array_column($results, 0))): ?>
  <div class="tip">
    ✓ All done! Open <a href="/secure-admin-9a2024" style="color:#60a5fa">secure-admin-9a2024</a> in a fresh <strong>incognito window</strong> to log in.
  </div>
  <?php endif; ?>
  <div class="div"></div>
  <?php endif; ?>

  <?php if (!$appRoot): ?>
  <div class="r fail"><span class="ico">✕</span><span>Cannot find app folder with vendor/. Make sure the 9associates folder is uploaded.</span></div>
  <div class="div"></div>
  <?php endif; ?>

  <?php if ($appRoot && empty($results)): ?>
  <form method="POST">
    <button name="action" value="setup" class="btn btn-blue">▶ Run Setup (write .env, clear caches, fix permissions)</button>
  </form>
  <div class="div"></div>
  <?php endif; ?>

  <form method="POST" onsubmit="return confirm('Delete setup.php from the server?')">
    <button name="action" value="delete" class="btn btn-red">Delete setup.php</button>
  </form>

  <?php endif; ?>
</div>
</body>
</html>
