<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$pattern = "#'\\{\\{ stock_img\\('(photo-[0-9a-z-]+)'\\) \\}\\}'#";

$files = array_merge(
    glob("{$root}/resources/views/**/*.blade.php") ?: [],
    glob("{$root}/resources/views/*.blade.php") ?: [],
    glob("{$root}/app/Models/*.php") ?: []
);

$updated = 0;

foreach (array_unique($files) as $path) {
    $content = file_get_contents($path);
    $original = $content;

    $isModel = str_contains($path, DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Models'.DIRECTORY_SEPARATOR);
    $replacement = $isModel ? "StockImage::url('$1')" : "stock_img('$1')";

    $content = preg_replace($pattern, $replacement, $content);

    if ($isModel && $content !== $original && ! str_contains($content, 'use App\\Helpers\\StockImage;')) {
        $content = preg_replace(
            '/(namespace App\\\\Models;\\R\\R)/',
            "$1use App\\Helpers\\StockImage;\n\n",
            $content,
            1
        );
    }

    if ($content !== $original) {
        file_put_contents($path, $content);
        echo "fixed: {$path}\n";
        $updated++;
    }
}

echo "\n{$updated} files fixed\n";
