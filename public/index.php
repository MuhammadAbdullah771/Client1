<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Resolve app root — works on localhost AND shared hosting without any changes
// Local:   public/../            (vendor is one level up)
// cPanel:  public_html/../9associates/  (project above public_html)
// cPanel fallback: public_html/9associates/  (project inside public_html)
if (is_dir(__DIR__ . '/../vendor')) {
    define('APP_BASE', __DIR__ . '/..');
} elseif (is_dir(__DIR__ . '/../9associates/vendor')) {
    define('APP_BASE', __DIR__ . '/../9associates');
} elseif (is_dir(__DIR__ . '/9associates/vendor')) {
    define('APP_BASE', __DIR__ . '/9associates');
} else {
    http_response_code(500);
    die('<pre style="font-family:sans-serif;color:#dc2626;padding:30px;font-size:14px">'
      . "<b>9Associates — Setup Error</b>\n\n"
      . "Cannot find vendor/ folder. Checked:\n"
      . "  " . realpath(__DIR__ . '/..') . "/vendor/\n"
      . "  " . realpath(__DIR__ . '/..') . "/9associates/vendor/\n"
      . "  " . __DIR__ . "/9associates/vendor/\n\n"
      . "Make sure the project folder is uploaded correctly.\n"
      . '</pre>');
}

if (file_exists($maintenance = APP_BASE . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

require APP_BASE . '/vendor/autoload.php';

$app = require_once APP_BASE . '/bootstrap/app.php';

$app->handleRequest(Request::capture());
