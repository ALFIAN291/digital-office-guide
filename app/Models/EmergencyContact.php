<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'extension',
        'location',
        'operating_hours',
        'is_hotline',
        'sort_order',
    ];

    protected $casts = [
        'is_hotline' => 'boolean',
    ];
}

