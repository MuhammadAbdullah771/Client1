<?php

declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use App\Helpers\StockImage;

$outDir = __DIR__.'/../public/images';
if (! is_dir($outDir)) {
    mkdir($outDir, 0755, true);
}

$ids = StockImage::allPhotoIds();
$ok = 0;
$fail = 0;

foreach ($ids as $photoId) {
    $dest = $outDir.'/'.$photoId.'.jpg';
    if (file_exists($dest) && filesize($dest) > 1000) {
        echo "skip {$photoId}\n";
        $ok++;
        continue;
    }

    $url = "https://images.unsplash.com/{$photoId}?auto=format&fit=crop&w=1400&q=80";
    $ctx = stream_context_create([
        'http' => [
            'header' => "User-Agent: 9Associates-Asset-Sync/1.0\r\n",
            'timeout' => 30,
        ],
    ]);

    $data = @file_get_contents($url, false, $ctx);
    if ($data === false || strlen($data) < 1000) {
        echo "FAIL {$photoId}\n";
        $fail++;
        continue;
    }

    file_put_contents($dest, $data);
    echo "ok   {$photoId}\n";
    $ok++;
}

$logo = __DIR__.'/../public/logo.jpeg';
$seo = $outDir.'/seo-default.jpg';
if (file_exists($logo) && ! file_exists($seo)) {
    copy($logo, $seo);
    echo "ok   seo-default.jpg (from logo.jpeg)\n";
}

echo "\nDone: {$ok} ok, {$fail} failed\n";
exit($fail > 0 ? 1 : 0);
