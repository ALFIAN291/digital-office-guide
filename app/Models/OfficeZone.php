<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeZone extends Model
{
    protected $fillable = [
        'building',
        'floor',
        'code',
        'name',
        'type',
        'coord_x',
        'coord_y',
        'description',
        'contact_person',
        'sort_order',
        'area_group',
        'capacity',
        'facilities_list',
        'usage_info',
        'how_to_book',
        'image_path',
    ];

    protected $casts = [
        'coord_x' => 'float',
        'coord_y' => 'float',
    ];
}

