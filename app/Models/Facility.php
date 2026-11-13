<?php

namespace App\Models;

use App\Support\OfficeConceptData;
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
        'gallery_images',
        'availability_note',
        'usage_purpose',
        'booking_url',
        'how_to_use_steps',
    ];

    protected $casts = [
        'amenities' => 'array',
        'gallery_images' => 'array',
        'how_to_use_steps' => 'array',
        'is_featured' => 'boolean',
    ];

    /**
     * Resolve gallery image URLs for interactive slide carousel.
     */
    public function getGalleryListAttribute(): array
    {
        return OfficeConceptData::facilityGallery($this);
    }

    /**
     * Resolve 5-step "How to Use" workflow steps for this facility.
     */
    public function getUsageStepsAttribute(): array
    {
        if (!empty($this->how_to_use_steps) && is_array($this->how_to_use_steps)) {
            return $this->how_to_use_steps;
        }
        return OfficeConceptData::defaultFacilitySteps($this->category ?? 'service', $this->name ?? '');
    }
}

