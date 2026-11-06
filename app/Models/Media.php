<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'file_url',
        'file_type',
        'mime_type',
        'file_size',
        'alt_text',
        'category',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope: Get active media
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Get media by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope: Get media by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('file_type', $type);
    }

    /**
     * Get URL for display
     */
    public function getUrl()
    {
        return $this->file_url;
    }

    /**
     * Check if media is an image
     */
    public function isImage()
    {
        return $this->file_type === 'image' || str_starts_with($this->mime_type, 'image/');
    }
}
