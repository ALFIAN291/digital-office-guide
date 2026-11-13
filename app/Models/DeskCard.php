<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeskCard extends Model
{
    protected $fillable = [
        'name',
        'department',
        'sub_team',
        'desk_number',
        'floor',
        'area',
        'image_path',
    ];

    /**
     * Build the personalized onboarding URL encoded inside the desk QR code.
     */
    public function getQrUrlAttribute(): string
    {
        return url('/?' . http_build_query([
            'desk' => $this->desk_number,
        ]));
    }

    /**
     * Resolve the Front Side building/office photo URL (custom uploaded or default).
     */
    public function getCardImageUrlAttribute(): string
    {
        return office_image($this->image_path, 'images/hero-office.jpg');
    }
}
