<?php

use App\Support\OfficeConceptData;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Translate unmodified default English seed strings to Bahasa Indonesia.
     */
    public function up(): void
    {
        if (Schema::hasTable('home_settings')) {
            try {
                $settings = DB::table('home_settings')->get();
                $homeMap = [
                    'office_subtitle' => ['OFFICE GUIDE 2026' => 'PANDUAN KANTOR 2026'],
                    'hero_badge' => ['Karawang Plant & Office Complex' => 'Kompleks Kantor & Pabrik Karawang'],
                    'hero_title_line1' => ['Welcome to' => 'Selamat Datang di'],
                    'hero_title_line2' => [
                        'Your New Workplace' => 'Lingkungan Kerja Baru Anda',
                        'Our New Workplace' => 'Lingkungan Kerja Baru Kita',
                    ],
                    'hero_tagline' => ['Moving Together. Working Better. Growing Stronger.' => 'Melangkah Bersama. Bekerja Lebih Baik. Tumbuh Lebih Kuat.'],
                    'explore_title' => ['Explore Your Workplace' => 'Jelajahi Lingkungan Kerja Anda'],
                    'card_office_title' => ['Office & Plant' => 'Kantor & Pabrik'],
                    'card_facilities_title' => ['Facilities' => 'Fasilitas'],
                    'card_map_title' => ['Office Map' => 'Denah Kantor'],
                    'card_rules_title' => ["Dos & Don'ts" => 'Etiket & Aturan (K3)'],
                    'safety_title' => ['Zero Accident & Budaya 5S' => 'Nihil Kecelakaan & Budaya 5R'],
                ];

                foreach ($settings as $row) {
                    $updates = [];
                    foreach ($homeMap as $col => $replacements) {
                        if (isset($row->$col, $replacements[$row->$col])) {
                            $updates[$col] = $replacements[$row->$col];
                        }
                    }
                    if (!empty($updates)) {
                        DB::table('home_settings')->where('id', $row->id)->update($updates);
                    }
                }
            } catch (\Throwable $e) {
            }
        }

        if (Schema::hasTable('management_messages')) {
            try {
                $messages = DB::table('management_messages')->get();
                $msgMap = [
                    'title' => ['A Message from Management' => 'Pesan dari Manajemen'],
                    'badge_label' => ['Official Announcement' => 'Pengumuman Resmi'],
                    'subtitle' => [
                        'Karawang Office 2026' => 'Kantor Karawang 2026',
                        'Akebono Karawang 2026' => 'Akebono Karawang 2026',
                    ],
                    'sender_name' => ['Board of Management Akebono Brake Astra Indonesia' => 'Jajaran Manajemen PT Akebono Brake Astra Indonesia'],
                    'sender_role' => ['President Director & Executive Committee' => 'Presiden Direktur & Komite Eksekutif'],
                    'summary' => [
                        'As we begin a new chapter at our Karawang office, let us build a safer, more collaborative, and future-ready workplace — together.'
                        => 'Saat kita memulai babak baru di kantor Karawang, mari bersama membangun tempat kerja yang lebih aman, kolaboratif, dan siap menghadapi masa depan.',
                    ],
                    'quote' => ['Moving Together. Working Better. Growing Stronger.' => 'Melangkah Bersama. Bekerja Lebih Baik. Tumbuh Lebih Kuat.'],
                ];

                foreach ($messages as $row) {
                    $updates = [];
                    foreach ($msgMap as $col => $replacements) {
                        if (isset($row->$col, $replacements[$row->$col])) {
                            $updates[$col] = $replacements[$row->$col];
                        }
                    }
                    if (!empty($updates)) {
                        DB::table('management_messages')->where('id', $row->id)->update($updates);
                    }
                }
            } catch (\Throwable $e) {
            }
        }

        if (Schema::hasTable('dos_and_donts')) {
            try {
                $doMap = [
                    'Keep shared spaces clean.' => 'Jaga kebersihan ruang bersama.',
                    'Respect meeting schedules.' => 'Patuhi jadwal pemakaian ruang rapat.',
                    'Dispose of waste properly.' => 'Buang sampah pada tempat sesuai jenisnya.',
                    'Clean whiteboard & return chairs.' => 'Bersihkan papan tulis & rapikan kursi.',
                    'Silence mobile phones.' => 'Aktifkan mode hening pada ponsel.',
                    'Implement 5S & Clean Desk Policy.' => 'Terapkan 5R & Kebijakan Meja Bersih.',
                    'Use phone booth for long calls.' => 'Gunakan bilik telepon untuk panggilan panjang.',
                    'Keep aisles & walkways clear.' => 'Jaga lorong & jalur jalan tetap leluasa.',
                    'Return trays & cutlery to racks.' => 'Kembalikan baki & alat makan ke rak.',
                    'Queue orderly & take mindful portions.' => 'Antre tertib & ambil porsi secukupnya.',
                    'Maintain dining cleanliness.' => 'Jaga kebersihan area ruang makan.',
                    'Wear required PPE in plant zones.' => 'Gunakan APD wajib di area pabrik (Plant).',
                    'Walk within green pedestrian lanes.' => 'Berjalanlah di dalam jalur hijau pejalan kaki.',
                    'Report hazards & near-misses.' => 'Segera laporkan bahaya & potensi insiden.',
                ];

                $dontMap = [
                    'Leave personal items behind.' => 'Jangan tinggalkan barang pribadi sembarangan.',
                    'Leave devices running.' => 'Jangan biarkan perangkat elektronik tetap menyala.',
                    'Eat outside designated areas.' => 'Jangan makan di luar area yang ditentukan.',
                    'Leave food scraps & used cups.' => 'Jangan tinggalkan sisa makanan & gelas kotor.',
                    'Conduct loud side-conversations.' => 'Jangan mengobrol keras di samping saat rapat.',
                    'Leave confidential items unlocked.' => 'Jangan tinggalkan dokumen rahasia tanpa dikunci.',
                    'Talk loudly on speakerphones.' => 'Jangan berbicara keras lewat speakerphone.',
                    'Run loose cords across walkways.' => 'Jangan membentangkan kabel melintasi lorong.',
                    'Leave dirty tableware on tables.' => 'Jangan tinggalkan piring kotor di meja makan.',
                    'Cut queues or waste food.' => 'Jangan menyerobot antrean atau membuang makanan.',
                    'Bring pungent food to office desks.' => 'Jangan bawa makanan berbau tajam ke meja kerja.',
                    'Enter plant without safety gear.' => 'Jangan masuk area pabrik tanpa alat pelindung diri.',
                    'Look down at phones while walking.' => 'Jangan menatap layar ponsel saat berjalan.',
                    'Block fire extinguishers or exits.' => 'Jangan menghalangi APAR atau pintu darurat.',
                ];

                $rules = DB::table('dos_and_donts')->get();
                foreach ($rules as $rule) {
                    $updates = [];
                    if (isset($doMap[$rule->do_text])) {
                        $updates['do_text'] = $doMap[$rule->do_text];
                    }
                    if (isset($doMap[$rule->title])) {
                        $updates['title'] = $doMap[$rule->title];
                    }
                    if (isset($dontMap[$rule->dont_text])) {
                        $updates['dont_text'] = $dontMap[$rule->dont_text];
                    }
                    if (!empty($updates)) {
                        DB::table('dos_and_donts')->where('id', $rule->id)->update($updates);
                    }
                }
            } catch (\Throwable $e) {
            }
        }

        if (Schema::hasTable('facilities')) {
            try {
                $availMap = [
                    'Check on room tablet or SSO Portal' => 'Cek di tablet ruangan atau Portal SSO',
                    'Check on room tablet / SSO' => 'Cek di tablet ruangan / Portal SSO',
                ];
                $usageMap = [
                    'Internal meeting, video conference, and team discussion' => 'Rapat internal, konferensi video, dan diskusi tim',
                    'Internal & cross-team meetings' => 'Rapat internal & diskusi lintas departemen',
                    'Shift lunch, refreshment, and collaborative break' => 'Makan siang shift, penyegaran, dan istirahat bersama',
                    'Daily work, engineering review, and focus calls' => 'Pekerjaan harian, peninjauan teknis, dan panggilan fokus',
                    'Prayer, rest, or nursing support' => 'Ibadah, istirahat, atau fasilitas ibu menyusui',
                    'First aid, emergency medical care, and HSE check' => 'Pertolongan pertama (P3K), penanganan medis darurat, dan pemeriksaan K3',
                    'Visitor check-in, reception, and access support' => 'Registrasi tamu, resepsionis, dan dukungan akses masuk',
                ];

                $englishStepMarkers = [
                    'Book via SSO Portal',
                    'Check Daily Menu & Hours',
                    'Locate Your Assigned Zone',
                    'Verify Facility Etiquette',
                    'Report Condition Immediately',
                    'Pre-Register or Arrive at Desk',
                ];

                $facilities = DB::table('facilities')->get();
                foreach ($facilities as $facility) {
                    $updates = [];
                    if (isset($availMap[$facility->availability_note])) {
                        $updates['availability_note'] = $availMap[$facility->availability_note];
                    }
                    if (isset($usageMap[$facility->usage_purpose])) {
                        $updates['usage_purpose'] = $usageMap[$facility->usage_purpose];
                    }
                    if ($facility->slug === 'meeting-room-5') {
                        if ($facility->name === 'Meeting Room 5') {
                            $updates['name'] = 'Ruang Rapat 5 (Meeting Room 5)';
                        }
                        if ($facility->location_detail === '2nd Floor (East Wing)') {
                            $updates['location_detail'] = 'Lantai 2 (Sayap Timur)';
                        }
                        if ($facility->capacity === '8 – 10 people') {
                            $updates['capacity'] = '8 – 10 orang';
                        }
                        if (str_starts_with((string) $facility->guidelines, 'Book the room in advance via SSO Portal.')) {
                            $updates['guidelines'] = "Pesan ruangan terlebih dahulu melalui Portal SSO.\nJaga kebersihan dan kerapian ruangan.\nMatikan layar & perlengkapan setelah selesai digunakan.\nHadir tepat waktu dan hargai jadwal pengguna berikutnya.";
                        }
                        if ($facility->amenities === json_encode(['Display (4K)', 'Camera (VC)', 'Microphone (Beamforming)', 'Speaker (Audio)', 'Video Conference'])) {
                            $updates['amenities'] = json_encode(['Layar (4K)', 'Kamera (VC)', 'Mikrofon (Beamforming)', 'Speaker (Audio)', 'Konferensi Video']);
                        }
                    }

                    if (!empty($facility->how_to_use_steps)) {
                        $stepsJson = (string) $facility->how_to_use_steps;
                        foreach ($englishStepMarkers as $marker) {
                            if (str_contains($stepsJson, $marker)) {
                                $updates['how_to_use_steps'] = json_encode(
                                    OfficeConceptData::defaultFacilitySteps($facility->category ?? 'service', $facility->name ?? '')
                                );
                                break;
                            }
                        }
                    }

                    if (!empty($updates)) {
                        DB::table('facilities')->where('id', $facility->id)->update($updates);
                    }
                }
            } catch (\Throwable $e) {
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Data localization does not require destructive rollback.
    }
};
