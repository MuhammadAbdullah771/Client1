<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseStudy extends Model
{
    protected $fillable = [
        'title',
        'challenge',
        'result',
        'metric_value',
        'metric_label',
        'sector',
        'service',
        'image',
        'timeline_months',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];
}

