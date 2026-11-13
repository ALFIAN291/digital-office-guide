<?php

use App\Support\OfficeConceptData;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('management_messages')) {
            Schema::table('management_messages', function (Blueprint $table) {
                if (!Schema::hasColumn('management_messages', 'japanese_tagline')) {
                    $table->string('japanese_tagline')->nullable();
                }
                if (!Schema::hasColumn('management_messages', 'video_url')) {
                    $table->text('video_url')->nullable();
                }
                if (!Schema::hasColumn('management_messages', 'video_duration')) {
                    $table->string('video_duration')->nullable()->default('1:18');
                }
                if (!Schema::hasColumn('management_messages', 'video_chapters')) {
                    $table->json('video_chapters')->nullable();
                }
            });

            try {
                DB::table('management_messages')
                    ->whereNull('japanese_tagline')
                    ->update([
                        'japanese_tagline' => '新しい職場で、ともに次の未来へ',
                        'video_duration' => '1:18',
                        'video_chapters' => json_encode(OfficeConceptData::defaultVideoChapters()),
                    ]);
            } catch (\Throwable $e) {
            }
        }

        if (Schema::hasTable('facilities')) {
            Schema::table('facilities', function (Blueprint $table) {
                if (!Schema::hasColumn('facilities', 'gallery_images')) {
                    $table->json('gallery_images')->nullable();
                }
                if (!Schema::hasColumn('facilities', 'availability_note')) {
                    $table->string('availability_note')->nullable();
                }
                if (!Schema::hasColumn('facilities', 'usage_purpose')) {
                    $table->string('usage_purpose')->nullable();
                }
                if (!Schema::hasColumn('facilities', 'booking_url')) {
                    $table->text('booking_url')->nullable();
                }
                if (!Schema::hasColumn('facilities', 'how_to_use_steps')) {
                    $table->json('how_to_use_steps')->nullable();
                }
            });

            try {
                $facilities = DB::table('facilities')->get();
                foreach ($facilities as $facility) {
                    $updates = [];
                    if (empty($facility->availability_note)) {
                        $updates['availability_note'] = $facility->category === 'meeting'
                            ? 'Check on room tablet or SSO Portal'
                            : ($facility->operating_hours ?? '07:30 - 17:30 WIB');
                    }
                    if (empty($facility->usage_purpose)) {
                        $updates['usage_purpose'] = match ($facility->category) {
                            'meeting' => 'Internal meeting, video conference, and team discussion',
                            'dining' => 'Shift lunch, refreshment, and collaborative break',
                            'workspace' => 'Daily work, engineering review, and focus calls',
                            'wellness' => 'Prayer, rest, or nursing support',
                            'safety' => 'First aid, emergency medical care, and HSE check',
                            default => 'Visitor check-in, reception, and access support',
                        };
                    }
                    if (empty($facility->how_to_use_steps)) {
                        $updates['how_to_use_steps'] = json_encode(
                            OfficeConceptData::defaultFacilitySteps($facility->category ?? 'service', $facility->name ?? '')
                        );
                    }
                    if (!empty($updates)) {
                        DB::table('facilities')->where('id', $facility->id)->update($updates);
                    }
                }
            } catch (\Throwable $e) {
            }
        }

        if (Schema::hasTable('office_zones')) {
            Schema::table('office_zones', function (Blueprint $table) {
                if (!Schema::hasColumn('office_zones', 'area_group')) {
                    $table->string('area_group')->nullable();
                }
                if (!Schema::hasColumn('office_zones', 'capacity')) {
                    $table->string('capacity')->nullable();
                }
                if (!Schema::hasColumn('office_zones', 'facilities_list')) {
                    $table->text('facilities_list')->nullable();
                }
                if (!Schema::hasColumn('office_zones', 'usage_info')) {
                    $table->string('usage_info')->nullable();
                }
                if (!Schema::hasColumn('office_zones', 'how_to_book')) {
                    $table->string('how_to_book')->nullable();
                }
                if (!Schema::hasColumn('office_zones', 'image_path')) {
                    $table->text('image_path')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('management_messages')) {
            Schema::table('management_messages', function (Blueprint $table) {
                $cols = array_filter(['japanese_tagline', 'video_url', 'video_duration', 'video_chapters'], fn ($c) => Schema::hasColumn('management_messages', $c));
                if (!empty($cols)) {
                    $table->dropColumn($cols);
                }
            });
        }

        if (Schema::hasTable('facilities')) {
            Schema::table('facilities', function (Blueprint $table) {
                $cols = array_filter(['gallery_images', 'availability_note', 'usage_purpose', 'booking_url', 'how_to_use_steps'], fn ($c) => Schema::hasColumn('facilities', $c));
                if (!empty($cols)) {
                    $table->dropColumn($cols);
                }
            });
        }

        if (Schema::hasTable('office_zones')) {
            Schema::table('office_zones', function (Blueprint $table) {
                $cols = array_filter(['area_group', 'capacity', 'facilities_list', 'usage_info', 'how_to_book', 'image_path'], fn ($c) => Schema::hasColumn('office_zones', $c));
                if (!empty($cols)) {
                    $table->dropColumn($cols);
                }
            });
        }
    }
};
