<?php

namespace App\Models;

use App\Support\OfficeConceptData;
use Illuminate\Database\Eloquent\Model;

class ManagementMessage extends Model
{
    protected $fillable = [
        'title',
        'badge_label',
        'subtitle',
        'sender_name',
        'sender_role',
        'summary',
        'content',
        'quote',
        'image_path',
        'is_active',
        'show_core_values',
        'val_1_title',
        'val_1_desc',
        'val_2_title',
        'val_2_desc',
        'val_3_title',
        'val_3_desc',
        'japanese_tagline',
        'video_url',
        'video_duration',
        'video_chapters',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_core_values' => 'boolean',
        'video_chapters' => 'array',
    ];

    /**
     * Resolve interactive video chapters for Concept Slide 2 player.
     */
    public function getChaptersListAttribute(): array
    {
        if (!empty($this->video_chapters) && is_array($this->video_chapters)) {
            return $this->video_chapters;
        }
        return OfficeConceptData::defaultVideoChapters();
    }
}

