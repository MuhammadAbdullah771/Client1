<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'icon',
        'order',
        'is_active',
        'contact_email',
        'contact_message',
        'intro_text',
        'main_heading',
        'content_paragraph_1',
        'content_paragraph_2',
        'services_list',
        'additional_info_title',
        'additional_info_content',
        'additional_info_link',
        'section_title',
        'section_content_1',
        'section_content_2',
        'section_content_3',
        'contact_cta_text',
        'contact_cta_link',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get translated title based on service title mapping
     */
    public function getTranslatedTitleAttribute()
    {
        $titleMap = [
            'Accounting' => __('common.service_accounting'),
            'Tax' => __('common.service_tax'),
            'Policies and Procedures' => __('common.service_policies_and_procedures'),
            'Policies and procedures' => __('common.service_policies_and_procedures'),
            'Financial Administration' => __('common.service_financial_administration'),
            'Financial administration' => __('common.service_financial_administration'),
            'IT Support' => __('common.service_it_support'),
        ];

        return $titleMap[$this->title] ?? $this->title;
    }

    /**
     * Get translated description - now returns database description directly
     * Each service has its own unique description stored in the database
     */
    public function getTranslatedDescriptionAttribute()
    {
        return $this->description;
    }

    public function portfolioItems(): HasMany
    {
        return $this->hasMany(PortfolioItem::class)->orderBy('order');
    }

    public function subServices(): HasMany
    {
        return $this->hasMany(SubService::class)->orderBy('order');
    }

    public function activeSubServices(): HasMany
    {
        return $this->hasMany(SubService::class)->where('is_active', true)->orderBy('order');
    }

    /**
     * Active services for public display (services listing, nav).
     */
    public static function forDisplay()
    {
        return self::where('is_active', true)
            ->orderBy('order')
            ->orderBy('id')
            ->get();
    }

    /**
     * Auto-generate professional image based on service keywords
     */
    public function getAutoImageAttribute()
    {
        $keywords = strtolower($this->title.' '.$this->description);

        // Map service types to professional Unsplash search terms
        if (str_contains($keywords, 'account') || str_contains($keywords, 'audit') || str_contains($keywords, 'bookkeep')) {
            return stock_img('photo-1554224155-8d04cb21cd6c');
        } elseif (str_contains($keywords, 'tax')) {
            return stock_img('photo-1450101499163-c8848c66ca85');
        } elseif (str_contains($keywords, 'polic') || str_contains($keywords, 'procedure') || str_contains($keywords, 'compliance')) {
            return stock_img('photo-1450101215322-bf5cd27642fc');
        } elseif (str_contains($keywords, 'financial') || str_contains($keywords, 'finance')) {
            return stock_img('photo-1579621970563-ebec7560ff3e');
        } elseif (str_contains($keywords, 'it') || str_contains($keywords, 'tech') || str_contains($keywords, 'software') || str_contains($keywords, 'cyber')) {
            return stock_img('photo-1550751827-4bd374c3f58b');
        } else {
            // Default professional business image
            return stock_img('photo-1507679799987-c73779587ccf');
        }
    }

    /**
     * Get the full URL for the image (prioritize auto-generated)
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return ImageHelper::url($this->image);
        }

        // Fallback to auto-generated image
        return $this->getAutoImageAttribute();
    }

    /**
     * Get default professional photo URL for services without images
     * Returns professional finance/accounting related images from Unsplash
     */
    public function getDefaultImageUrlAttribute()
    {
        // Map service titles to professional finance/accounting images
        $defaultImages = [
            'Accounting' => stock_img('photo-1554224155-6726b3ff858f'), // Professional accountant with documents
            'Tax' => stock_img('photo-1551288049-bebda4e38f71'), // Financial charts and analysis
            'Policies and Procedures' => stock_img('photo-1552664730-d307ca884978'), // Modern office professional
            'Policies and procedures' => stock_img('photo-1552664730-d307ca884978'), // Modern office professional
            'Financial Administration' => stock_img('photo-1554224155-8d04cb21cd6c'), // Financial statements review
            'Financial administration' => stock_img('photo-1554224155-8d04cb21cd6c'), // Financial statements review
            'IT Support' => stock_img('photo-1555066931-4365d14bab8c'), // Professional developer coding on laptop
        ];

        return $defaultImages[$this->title] ?? stock_img('photo-1554224155-6726b3ff858f'); // Default finance image
    }

    /**
     * Get the image URL with fallback to default professional photo
     */
    public function getDisplayImageUrlAttribute()
    {
        if ($this->image) {
            return $this->image_url;
        }

        return $this->default_image_url;
    }
}
