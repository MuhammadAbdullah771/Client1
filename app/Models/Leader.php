<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leader extends Model
{
    protected $fillable = [
        'name',
        'role',
        'department',
        'bio',
        'image',
        'email',
        'linkedin',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the full URL for the image
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        // If it's already a full URL, return as is
        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        // Ensure path starts with /storage/
        $imagePath = $this->image;
        if (!str_starts_with($imagePath, '/storage/')) {
            if (!str_starts_with($imagePath, '/')) {
                $imagePath = '/storage/' . $imagePath;
            } else {
                $imagePath = '/storage' . $imagePath;
            }
        }

        return asset($imagePath);
    }
}

