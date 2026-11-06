<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItManagerProfile extends Model
{
    protected $table = 'it_manager_profiles';

    protected $fillable = [
        'name',
        'image',
        'vision',
        'linkedin_url',
        'email',
        'whatsapp',
        'order',
    ];

    public function getImageUrlAttribute(): ?string
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

    public function getLinkedinUrlAttribute($value): ?string
    {
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }
        if (str_contains($value, 'linkedin.com/in/')) {
            return 'https://' . ltrim(preg_replace('#^https?://#', '', $value), '/');
        }
        return 'https://linkedin.com/in/' . ltrim($value, '/');
    }
}
