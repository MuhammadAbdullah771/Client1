<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubService extends Model
{
    protected $fillable = [
        'service_id',
        'title',
        'description',
        'image',
        'order',
        'is_active',
        'heading_1',
        'content_1',
        'heading_2',
        'content_2',
        'heading_3',
        'content_3',
        'heading_4',
        'content_4',
        'heading_5',
        'content_5',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the service that owns this sub-service
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the full URL for the image
     */
    public function getImageUrlAttribute()
    {
        if (! $this->image) {
            return null;
        }

        return ImageHelper::url($this->image);
    }
}
