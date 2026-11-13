<?php

namespace App\Models;

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
     * Resolve the playlist of videos (Nama Video + URL Video) for the right-side list.
     */
    public function getChaptersListAttribute(): array
    {
        if (!empty($this->video_chapters) && is_array($this->video_chapters)) {
            // Only use saved playlist items that use the new video playlist structure (have 'video_url' key)
            $validItems = array_values(array_filter($this->video_chapters, function ($item) {
                return is_array($item) && array_key_exists('video_url', $item);
            }));
            if (!empty($validItems)) {
                return array_map(function ($item, $idx) {
                    $url = trim((string) ($item['video_url'] ?? ''));
                    return [
                        'id' => $item['id'] ?? ('vid-' . ($idx + 1)),
                        'title' => !empty($item['title']) ? $item['title'] : ('Video ' . ($idx + 1)),
                        'video_url' => $url,
                    ];
                }, $validItems, array_keys($validItems));
            }
        }

        return [
            [
                'id' => 'vid-1',
                'title' => $this->title ?: 'Video Sambutan Manajemen',
                'video_url' => $this->video_url ?? '',
            ],
        ];
    }
}
