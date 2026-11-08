<?php
if (!isset($_GET['token']) || $_GET['token'] !== 'setup9associates2024') {
    die('Forbidden');
}

echo "<h2>Server Info</h2>";
echo "PHP: " . phpversion() . "<br>";
echo "exec disabled: " . (function_exists('exec') ? 'NO (available)' : 'YES (blocked)') . "<br>";
echo "shell_exec disabled: " . (function_exists('shell_exec') ? 'NO (available)' : 'YES (blocked)') . "<br>";
echo "proc_open disabled: " . (function_exists('proc_open') ? 'NO (available)' : 'YES (blocked)') . "<br>";
echo "popen disabled: " . (function_exists('popen') ? 'NO (available)' : 'YES (blocked)') . "<br>";
echo "system disabled: " . (function_exists('system') ? 'NO (available)' : 'YES (blocked)') . "<br>";
echo "passthru disabled: " . (function_exists('passthru') ? 'NO (available)' : 'YES (blocked)') . "<br>";
echo "<br>";

$base = dirname(__DIR__);
echo "Project root: $base<br>";
echo "vendor exists: " . (is_dir($base . '/vendor') ? 'YES' : 'NO') . "<br>";
echo "composer.json exists: " . (file_exists($base . '/composer.json') ? 'YES' : 'NO') . "<br>";
echo ".env exists: " . (file_exists($base . '/.env') ? 'YES' : 'NO') . "<br>";
echo "<br>";

echo "<h2>Disabled Functions</h2>";
echo ini_get('disable_functions') ?: 'none listed';
