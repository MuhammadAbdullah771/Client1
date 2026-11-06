<?php

namespace App\Support;

class ImageUrlHelper
{
    public static function normalize(?string $url): ?string
    {
        if ($url === null) {
            return null;
        }

        $url = trim($url);
        if ($url === '') {
            return null;
        }

        return self::convertGoogleDriveLink($url);
    }

    public static function convertGoogleDriveLink(string $url): string
    {
        $url = trim($url);

        if (str_contains($url, '/uc?export=view&id=') || str_contains($url, '/uc?export=download&id=')) {
            return $url;
        }

        $fileId = null;

        if (preg_match('/\/file\/d\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $fileId = $matches[1];
        } elseif (preg_match('/[?&]id=([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $fileId = $matches[1];
        }

        if ($fileId) {
            return "https://drive.google.com/uc?export=view&id={$fileId}";
        }

        return $url;
    }
}
