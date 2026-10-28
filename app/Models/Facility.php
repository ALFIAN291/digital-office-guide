<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'category',
        'floor',
        'location_detail',
        'capacity',
        'operating_hours',
        'description',
        'guidelines',
        'amenities',
        'icon',
        'image_path',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'amenities' => 'array',
        'is_featured' => 'boolean',
    ];
}

