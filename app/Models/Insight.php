<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Model;

class Insight extends Model
{
    protected $fillable = [
        'title',
        'heading',
        'excerpt',
        'content',
        'key_points', // JSON array of key points
        'category',
        'image',
        'is_featured',
        'published_at',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'date',
    ];

    /**
     * Auto-generate professional image based on insight keywords
     */
    public function getAutoImageAttribute()
    {
        $keywords = strtolower($this->title.' '.$this->category.' '.($this->heading ?? ''));

        // Map insight types to professional Unsplash search terms
        if (str_contains($keywords, 'tax') || str_contains($keywords, 'taxation')) {
            return stock_img('photo-1554224311-beee460201f0');
        } elseif (str_contains($keywords, 'account') || str_contains($keywords, 'financial') || str_contains($keywords, 'audit')) {
            return stock_img('photo-1460925895917-afdab827c52f');
        } elseif (str_contains($keywords, 'business') || str_contains($keywords, 'strategy') || str_contains($keywords, 'growth')) {
            return stock_img('photo-1552664730-d307ca884978');
        } elseif (str_contains($keywords, 'tech') || str_contains($keywords, 'digital') || str_contains($keywords, 'innovation')) {
            return stock_img('photo-1519389950473-47ba0277781c');
        } elseif (str_contains($keywords, 'legal') || str_contains($keywords, 'compliance') || str_contains($keywords, 'regulation')) {
            return stock_img('photo-1589829545856-d10d557cf95f');
        } else {
            // Default professional insight image
            return stock_img('photo-1486312338219-ce68d2c6f44d');
        }
    }

    /**
     * Get the full URL for the image
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return ImageHelper::url($this->image);
        }

        return $this->getAutoImageAttribute();
    }
}
