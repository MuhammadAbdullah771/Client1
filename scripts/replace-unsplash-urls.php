<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$dirs = ["{$root}/resources/views", "{$root}/app"];

$pattern = '#https://images\.unsplash\.com/(photo-[0-9a-z-]+)(?:\?[^\'"\s\)]*)?#';

$updated = 0;

foreach ($dirs as $dir) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if (! $file->isFile()) {
            continue;
        }
        $path = $file->getPathname();
        if (! preg_match('/\.(php|blade\.php)$/', $path)) {
            continue;
        }

        $content = file_get_contents($path);
        $original = $content;

        if (str_contains($path, DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR)) {
            $content = preg_replace_callback($pattern, static function (array $m): string {
                return "\\App\\Helpers\\StockImage::url('{$m[1]}')";
            }, $content);
        } else {
            $content = preg_replace_callback($pattern, static function (array $m): string {
                return "{{ stock_img('{$m[1]}') }}";
            }, $content);
        }

        if ($content !== $original) {
            file_put_contents($path, $content);
            echo "updated: {$path}\n";
            $updated++;
        }
    }
}

echo "\n{$updated} files updated\n";
