<?php
// One-time setup script — DELETE THIS FILE after running
if (!isset($_GET['token']) || $_GET['token'] !== 'setup9associates2024') {
    die('Forbidden');
}

$base = dirname(__DIR__);
$output = [];

// Run composer install
chdir($base);
exec('export COMPOSER_HOME=$HOME/.composer && composer install --no-dev --optimize-autoloader --no-interaction 2>&1', $output, $code);
echo "<h2>Composer Install (exit: $code)</h2><pre>" . implode("\n", $output) . "</pre>";

// Copy .env
if (!file_exists($base . '/.env')) {
    copy($base . '/.env.example', $base . '/.env');
    echo "<p>.env created from .env.example</p>";
} else {
    echo "<p>.env already exists</p>";
}

// Generate key
$output2 = [];
exec('php ' . $base . '/artisan key:generate --force 2>&1', $output2, $code2);
echo "<h2>Key Generate (exit: $code2)</h2><pre>" . implode("\n", $output2) . "</pre>";

// Cache
exec('php ' . $base . '/artisan config:cache 2>&1', $o, $c);
echo "<h2>Config Cache (exit: $c)</h2><pre>" . implode("\n", $o) . "</pre>";

exec('php ' . $base . '/artisan storage:link 2>&1', $o2, $c2);
echo "<h2>Storage Link (exit: $c2)</h2><pre>" . implode("\n", $o2) . "</pre>";

echo "<h2 style='color:green'>Done! Now DELETE this file from File Manager.</h2>";
