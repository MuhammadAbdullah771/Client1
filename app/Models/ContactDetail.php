<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactDetail extends Model
{
    protected $fillable = [
        'email',
        'address',
        'phone',
        'phone_2',
        'mobile',
        'fax',
        'office_hours',
        'website',
        'additional_info',
    ];

    /**
     * Get the single contact detail record (singleton pattern)
     */
    public static function getContactDetails()
    {
        return static::firstOrCreate(['id' => 1]);
    }
}
