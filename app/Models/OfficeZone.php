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
    ];

    protected $casts = [
        'coord_x' => 'float',
        'coord_y' => 'float',
    ];
}

