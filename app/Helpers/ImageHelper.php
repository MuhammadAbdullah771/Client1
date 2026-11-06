<?php

namespace App\Helpers;

use App\Support\ImageUrlHelper;

class ImageHelper
{
    /**
     * Get the correct image URL for display
     * Handles both local storage and external URLs
     */
    public static function url(?string $imagePath): ?string
    {
        if (empty($imagePath)) {
            return null;
        }

        // If it's already a full URL (http:// or https://), return as is
        if (str_starts_with($imagePath, 'http://') || str_starts_with($imagePath, 'https://')) {
            return ImageUrlHelper::normalize($imagePath);
        }

        // Public folder images (e.g. images/photo-xxx.jpg)
        if (str_starts_with($imagePath, 'images/') || str_starts_with($imagePath, '/images/')) {
            return asset(ltrim($imagePath, '/'));
        }

        // Ensure the path starts with /storage/
        if (! str_starts_with($imagePath, '/storage/')) {
            // If it doesn't start with /, add /storage/
            if (! str_starts_with($imagePath, '/')) {
                $imagePath = '/storage/'.$imagePath;
            } else {
                // If it starts with / but not /storage/, prepend /storage
                $imagePath = '/storage'.$imagePath;
            }
        }

        // Use asset() helper to generate full URL
        // This ensures it works with APP_URL from .env
        return asset($imagePath);
    }

    /**
     * Check if image file exists in storage
     */
    public static function exists(?string $imagePath): bool
    {
        if (empty($imagePath)) {
            return false;
        }

        // External URLs always "exist"
        if (str_starts_with($imagePath, 'http://') || str_starts_with($imagePath, 'https://')) {
            return true;
        }

        // Check local file
        $relativePath = str_replace('/storage/', '', $imagePath);
        $fullPath = storage_path('app/public/'.$relativePath);

        return file_exists($fullPath);
    }
}
