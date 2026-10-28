<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManagementMessage extends Model
{
    protected $fillable = [
        'title',
        'sender_name',
        'sender_role',
        'summary',
        'content',
        'quote',
        'image_path',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}

