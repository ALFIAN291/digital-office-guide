<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DosAndDont extends Model
{
    protected $table = 'dos_and_donts';

    protected $fillable = [
        'category',
        'image_path',
        'do_text',
        'do_sub',
        'dont_text',
        'dont_sub',
        'sort_order',
        'is_active',
        // Legacy fields for backward compatibility
        'type',
        'title',
        'description',
        'tip_or_consequence',
        'icon',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Helper accessor for image URL
     */
    public function getImageUrlAttribute(): string
    {
        return office_image($this->image_path, 'images/hero-office.jpg');
    }
}
