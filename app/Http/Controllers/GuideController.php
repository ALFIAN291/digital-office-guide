<?php

namespace App\Http\Controllers;

use App\Models\DeskCard;
use App\Models\DosAndDont;
use App\Models\EmergencyContact;
use App\Models\Facility;
use App\Models\ManagementMessage;
use App\Models\OfficeZone;
use App\Support\OfficeConceptData;
use Illuminate\Http\Request;

class GuideController extends Controller
{
    /**
     * Helper to render views with Vercel Edge caching for guest visitors.
     */
    protected function renderWithCache($view, array $data = [])
    {
        $response = response()->view($view, $data);
        if (!auth()->check() && app()->environment('production')) {
            $response->header('Cache-Control', 'public, max-age=60, s-maxage=300, stale-while-revalidate=600');
        } else {
            $response->header('Cache-Control', 'no-cache, no-store, must-revalidate, private');
        }
        return $response;
    }

    /**
     * Display the main home screen matching the design.
     */
    public function index(Request $request)
    {
        $scannedDesk = null;
        try {
            if ($request->filled('desk')) {
                $scannedDesk = DeskCard::where('desk_number', (string) $request->input('desk'))->first();
            }
            $message = ManagementMessage::where('is_active', true)->first();
            $facilities = Facility::orderBy('sort_order')->take(6)->get();
            $featuredFacilities = Facility::where('is_featured', true)->orderBy('sort_order')->get();
            $emergencyContacts = EmergencyContact::where('is_hotline', true)->orderBy('sort_order')->get();
            $rulesCount = DosAndDont::count();
            $zonesCount = OfficeZone::count();
        } catch (\Throwable $e) {
            $message = null;
            $facilities = collect();
            $featuredFacilities = collect();
            $emergencyContacts = collect();
            $rulesCount = 0;
            $zonesCount = 0;
        }

        if (!$message) {
            $message = new ManagementMessage([
                'title' => 'Pesan dari Manajemen',
                'sender_name' => 'Jajaran Direksi & Manajemen',
                'sender_role' => 'PT Akebono Brake Astra Indonesia',
                'content' => "Selamat datang di panduan fasilitas kantor baru Akebono Karawang.\n\nMari kita ciptakan tempat kerja yang nyaman, aman, dan produktif bersama.",
                'summary' => 'Saat kita memulai babak baru di kantor Karawang, mari bersama membangun tempat kerja yang lebih aman, kolaboratif, dan siap menghadapi masa depan.',
                'image_path' => 'images/management-office.jpg',
                'japanese_tagline' => '新しい職場で、ともに次の未来へ',
                'video_duration' => '1:18',
            ]);
        }

        $onboardingSteps = OfficeConceptData::onboardingSteps();
        $videoChapters = $message->chapters_list;
        $videoScenes = OfficeConceptData::videoSceneStrip();

        return $this->renderWithCache('guide.index', compact(
            'message',
            'facilities',
            'featuredFacilities',
            'emergencyContacts',
            'rulesCount',
            'zonesCount',
            'onboardingSteps',
            'videoChapters',
            'videoScenes',
            'scannedDesk'
        ));
    }

    /**
     * Display the Message from Management page.
     */
    public function message()
    {
        try {
            $message = ManagementMessage::where('is_active', true)->first();
        } catch (\Throwable $e) {
            $message = null;
        }

        if (!$message) {
            $message = new ManagementMessage([
                'title' => 'Pesan dari Manajemen',
                'sender_name' => 'Jajaran Direksi & Manajemen',
                'sender_role' => 'PT Akebono Brake Astra Indonesia',
                'content' => 'Selamat datang di fasilitas kantor Akebono Karawang.',
                'summary' => 'Membangun tempat kerja yang aman, kolaboratif, dan siap menyongsong masa depan.',
                'japanese_tagline' => '新しい職場で、ともに次の未来へ',
                'video_duration' => '1:18',
            ]);
        }

        $videoChapters = $message->chapters_list;
        $videoScenes = OfficeConceptData::videoSceneStrip();

        return $this->renderWithCache('guide.message', compact('message', 'videoChapters', 'videoScenes'));
    }

    /**
     * Display the Facilities page with filters & search.
     * All facilities are passed to view so filtering between categories and floors is instantaneous.
     */
    public function facilities(Request $request)
    {
        try {
            $facilities = Facility::orderBy('sort_order')->get();
            if ($facilities->isNotEmpty() && !$facilities->contains('slug', 'meeting-room-5')) {
                $this->ensureDefaultMeetingRoom5();
                $facilities = Facility::orderBy('sort_order')->get();
            }
        } catch (\Throwable $e) {
            $facilities = collect();
        }
        $matchingRules = collect();

        if ($request->filled('q')) {
            $searchTerm = '%' . $request->q . '%';
            $like = config('database.default') === 'pgsql' ? 'ilike' : 'like';

            try {
                $matchingRules = DosAndDont::where('do_text', $like, $searchTerm)
                    ->orWhere('dont_text', $like, $searchTerm)
                    ->orWhere('title', $like, $searchTerm)
                    ->orWhere('description', $like, $searchTerm)
                    ->take(6)
                    ->get();
            } catch (\Throwable $e) {
                $matchingRules = collect();
            }
        }

        $categories = [
            'all' => 'Semua Fasilitas',
            'workspace' => 'Area Kerja',
            'meeting' => 'Ruang Rapat',
            'dining' => 'Kantin & Makan',
            'wellness' => 'Kesehatan & Ibadah',
            'service' => 'Layanan & Parkir',
            'safety' => 'Keselamatan',
        ];

        $floors = ['all' => 'Semua Lantai', 'Lantai 1' => 'Lantai 1', 'Lantai 2' => 'Lantai 2', 'Plant Area' => 'Plant Area', 'Outdoor' => 'Outdoor'];

        return $this->renderWithCache('guide.facilities', compact('facilities', 'categories', 'floors', 'matchingRules'));
    }

    /**
     * Ensure Meeting Room 5 exists so Floor 2 Map & Facility Detail match the reference design.
     */
    protected function ensureDefaultMeetingRoom5(): void
    {
        if (!Facility::where('slug', 'meeting-room-5')->exists()) {
            Facility::create([
                'name' => 'Ruang Rapat 5 (Meeting Room 5)',
                'slug' => 'meeting-room-5',
                'category' => 'meeting',
                'floor' => 'Lantai 2',
                'location_detail' => 'Lantai 2 (Sayap Timur)',
                'capacity' => '8 – 10 orang',
                'operating_hours' => '07:30 - 18:00 WIB',
                'availability_note' => 'Cek di tablet ruangan / Portal SSO',
                'usage_purpose' => 'Rapat internal & diskusi lintas departemen',
                'description' => 'Ruang rapat kolaboratif di Lantai 2 yang dilengkapi layar pintar 4K, kamera konferensi video, mikrofon beamforming, dan sistem audio jernih untuk rapat internal maupun hybrid.',
                'guidelines' => "Pesan ruangan terlebih dahulu melalui Portal SSO.\nJaga kebersihan dan kerapian ruangan.\nMatikan layar & perlengkapan setelah selesai digunakan.\nHadir tepat waktu dan hargai jadwal pengguna berikutnya.",
                'amenities' => ['Layar (4K)', 'Kamera (VC)', 'Mikrofon (Beamforming)', 'Speaker (Audio)', 'Konferensi Video'],
                'icon' => 'users',
                'image_path' => '/images/meeting-room.jpg',
                'is_featured' => true,
                'sort_order' => 1,
            ]);
        }
    }

    /**
     * Display single facility details.
     */
    public function facilityDetail($slug)
    {
        try {
            $facility = Facility::where('slug', $slug)->first();
            if (!$facility && $slug === 'meeting-room-5') {
                $this->ensureDefaultMeetingRoom5();
                $facility = Facility::where('slug', $slug)->first();
            }
            if (!$facility) {
                return redirect()->route('guide.facilities');
            }
            $related = Facility::where('category', $facility->category)
                ->where('id', '!=', $facility->id)
                ->take(3)
                ->get();
            $allFacilities = Facility::orderBy('sort_order')->get(['id', 'name', 'slug', 'category', 'floor']);
        } catch (\Throwable $e) {
            return redirect()->route('guide.facilities');
        }

        return $this->renderWithCache('guide.facility-detail', compact('facility', 'related', 'allFacilities'));
    }

    /**
     * Display the Interactive Office Map.
     */
    public function map(Request $request)
    {
        $requestedFloor = (string) $request->input('floor', 'Lantai 2');
        $floorAliases = [
            '1F' => 'Lantai 1',
            '2F' => 'Lantai 2',
            '3F' => 'Ground Floor',
            'Plant Area' => 'Ground Floor',
        ];
        $floor = $floorAliases[$requestedFloor] ?? $requestedFloor;
        if (!in_array($floor, ['Lantai 1', 'Lantai 2', 'Ground Floor'], true)) {
            $floor = 'Lantai 2';
        }

        try {
            $zones = OfficeZone::where('floor', $floor)->orderBy('sort_order')->get();
            $allZones = OfficeZone::orderBy('sort_order')->get();
        } catch (\Throwable $e) {
            $zones = collect();
            $allZones = collect();
        }

        $floors = [
            'Lantai 1' => 'Lt. 1 • Gedung Utama Lantai 1',
            'Lantai 2' => 'Lt. 2 • Gedung Utama Lantai 2',
            'Ground Floor' => 'Pabrik 1 & Pabrik 2 (Kompleks)',
        ];

        $blueprints = OfficeConceptData::architecturalBlueprints();

        return $this->renderWithCache('guide.map', compact('zones', 'floor', 'floors', 'allZones', 'blueprints'));
    }

    /**
     * Display the Dos and Don'ts guideline page.
     * Guidelines are formatted in paired DO & DON'T cards matching the official mockup.
     * Always loaded dynamically from database so admin edits appear instantly.
     */
    public function dosAndDonts(Request $request)
    {
        $categories = [
            'General' => 'Etiket Umum',
            'Meeting Room' => 'Etiket Ruang Rapat',
            'Workspace' => 'Etiket Area Kerja',
            'Canteen' => 'Etiket Kantin',
            'Safety' => 'Etiket Keselamatan (K3)',
        ];

        try {
            $dbRules = DosAndDont::where('is_active', true)->orderBy('sort_order')->get();
            if ($dbRules->isEmpty()) {
                $this->seedDefaultDosAndDonts();
                $dbRules = DosAndDont::where('is_active', true)->orderBy('sort_order')->get();
            }
        } catch (\Throwable $e) {
            $dbRules = collect();
        }

        // Include any new custom categories added by admin
        foreach ($dbRules as $rule) {
            if (!empty($rule->category) && !isset($categories[$rule->category])) {
                $categories[$rule->category] = 'Etiket ' . $rule->category;
            }
        }

        $pairs = $dbRules->map(function ($rule) {
            return [
                'id' => (string) $rule->id,
                'category' => $rule->category,
                'image' => office_image($rule->image_path, 'images/hero-office.jpg'),
                'do' => $rule->do_text ?: ($rule->title ?: ''),
                'do_sub' => $rule->do_sub ?: ($rule->description ?: ''),
                'dont' => $rule->dont_text ?: '',
                'dont_sub' => $rule->dont_sub ?: '',
            ];
        })->values()->all();

        $initialCategory = (string) $request->input('category', 'General');
        $initialQuery = (string) $request->input('q', '');

        return $this->renderWithCache('guide.dos-and-donts', [
            'pairs' => $pairs,
            'categories' => $categories,
            'rules' => $dbRules,
            'initialCategory' => $initialCategory,
            'initialQuery' => $initialQuery,
        ]);
    }

    /**
     * Seed default 15 paired guidelines if database table is completely empty.
     */
    protected function seedDefaultDosAndDonts(): void
    {
        $defaults = [
            // General
            [
                'category' => 'General',
                'image_path' => '/images/hero-office.jpg',
                'do_text' => 'Jaga kebersihan ruang bersama.',
                'do_sub' => 'Rapikan area kerja dan jaga kebersihan fasilitas bersama.',
                'dont_text' => 'Jangan tinggalkan barang pribadi sembarangan.',
                'dont_sub' => 'Jangan meninggalkan barang pribadi atau sampah di area umum.',
                'sort_order' => 1,
                'is_active' => true,
                'type' => 'do',
                'title' => 'Jaga kebersihan ruang bersama.',
                'description' => 'Rapikan area kerja dan jaga kebersihan fasilitas bersama.',
            ],
            [
                'category' => 'General',
                'image_path' => '/images/meeting-room.jpg',
                'do_text' => 'Patuhi jadwal pemakaian ruang rapat.',
                'do_sub' => 'Hadir tepat waktu dan selesaikan rapat sesuai durasi.',
                'dont_text' => 'Jangan biarkan perangkat elektronik tetap menyala.',
                'dont_sub' => 'Jangan biarkan proyektor, lampu, atau monitor menyala setelah rapat.',
                'sort_order' => 2,
                'is_active' => true,
                'type' => 'do',
                'title' => 'Patuhi jadwal pemakaian ruang rapat.',
                'description' => 'Hadir tepat waktu dan selesaikan rapat sesuai durasi.',
            ],
            [
                'category' => 'General',
                'image_path' => '/images/facilities-office.jpg',
                'do_text' => 'Buang sampah pada tempat sesuai jenisnya.',
                'do_sub' => 'Pilah sampah organik, anorganik, dan residu pada tempatnya.',
                'dont_text' => 'Jangan makan di luar area yang ditentukan.',
                'dont_sub' => 'Hindari makan makanan berat di luar kantin atau pantry.',
                'sort_order' => 3,
                'is_active' => true,
                'type' => 'do',
                'title' => 'Buang sampah pada tempat sesuai jenisnya.',
                'description' => 'Pilah sampah organik, anorganik, dan residu pada tempatnya.',
            ],

            // Meeting Room
            [
                'category' => 'Meeting Room',
                'image_path' => '/images/meeting-room.jpg',
                'do_text' => 'Hormati jadwal penggunaan ruang rapat.',
                'do_sub' => 'Pesan ruangan sesuai kapasitas peserta dan batalkan jika tidak jadi digunakan.',
                'dont_text' => 'Jangan biarkan perangkat rapat tetap menyala.',
                'dont_sub' => 'Jangan biarkan AC, proyektor, dan layar video conference terus menyala.',
                'sort_order' => 4,
                'is_active' => true,
                'type' => 'do',
                'title' => 'Hormati jadwal penggunaan ruang rapat.',
                'description' => 'Pesan ruangan sesuai kapasitas peserta dan batalkan jika tidak jadi digunakan.',
            ],
            [
                'category' => 'Meeting Room',
                'image_path' => '/images/mockup-c2.jpg',
                'do_text' => 'Bersihkan papan tulis & rapikan kursi.',
                'do_sub' => 'Hapus papan tulis dan rapikan posisi kursi untuk tim pengguna selanjutnya.',
                'dont_text' => 'Jangan tinggalkan sisa makanan & gelas kotor.',
                'dont_sub' => 'Dilarang meninggalkan gelas kotor, sisa konsumsi, atau sampah berkas di meja.',
                'sort_order' => 5,
                'is_active' => true,
                'type' => 'do',
                'title' => 'Bersihkan papan tulis & rapikan kursi.',
                'description' => 'Hapus papan tulis dan rapikan posisi kursi untuk tim pengguna selanjutnya.',
            ],
            [
                'category' => 'Meeting Room',
                'image_path' => '/images/mockup-c1.jpg',
                'do_text' => 'Aktifkan mode hening pada ponsel.',
                'do_sub' => 'Ubah nada dering ponsel ke mode hening (getar) selama diskusi berlangsung.',
                'dont_text' => 'Jangan mengobrol keras di samping saat rapat.',
                'dont_sub' => 'Hindari berbisik keras atau menerima telepon pribadi di tengah jalannya meeting.',
                'sort_order' => 6,
                'is_active' => true,
                'type' => 'do',
                'title' => 'Aktifkan mode hening pada ponsel.',
                'description' => 'Ubah nada dering ponsel ke mode hening (getar) selama diskusi berlangsung.',
            ],

            // Workspace
            [
                'category' => 'Workspace',
                'image_path' => '/images/hero-office.jpg',
                'do_text' => 'Terapkan 5R & Kebijakan Meja Bersih.',
                'do_sub' => 'Rapikan meja dan simpan dokumen sebelum meninggalkan kantor setiap sore.',
                'dont_text' => 'Jangan tinggalkan dokumen rahasia tanpa dikunci.',
                'dont_sub' => 'Jangan meninggalkan dokumen rahasia, ID card, atau laptop tanpa dikunci (Win+L).',
                'sort_order' => 7,
                'is_active' => true,
                'type' => 'do',
                'title' => 'Terapkan 5R & Kebijakan Meja Bersih.',
                'description' => 'Rapikan meja dan simpan dokumen sebelum meninggalkan kantor setiap sore.',
            ],
            [
                'category' => 'Workspace',
                'image_path' => '/images/facilities-office.jpg',
                'do_text' => 'Gunakan bilik telepon untuk panggilan panjang.',
                'do_sub' => 'Gunakan private phone booth untuk percakapan intensif atau panggilan video.',
                'dont_text' => 'Jangan berbicara keras lewat speakerphone.',
                'dont_sub' => 'Hindari berbicara keras atau menggunakan speakerphone di area kerja terbuka.',
                'sort_order' => 8,
                'is_active' => true,
                'type' => 'do',
                'title' => 'Gunakan bilik telepon untuk panggilan panjang.',
                'description' => 'Gunakan private phone booth untuk percakapan intensif atau panggilan video.',
            ],
            [
                'category' => 'Workspace',
                'image_path' => '/images/mockup-mgmt.jpg',
                'do_text' => 'Jaga lorong & jalur jalan tetap leluasa.',
                'do_sub' => 'Pastikan jalur evakuasi dan bawah meja kerja bebas dari hambatan barang/kabel.',
                'dont_text' => 'Jangan membentangkan kabel melintasi lorong.',
                'dont_sub' => 'Dilarang melintangkan kabel listrik sembarangan yang berisiko tersandung.',
                'sort_order' => 9,
                'is_active' => true,
                'type' => 'do',
                'title' => 'Jaga lorong & jalur jalan tetap leluasa.',
                'description' => 'Pastikan jalur evakuasi dan bawah meja kerja bebas dari hambatan barang/kabel.',
            ],

            // Canteen
            [
                'category' => 'Canteen',
                'image_path' => '/images/mockup-c3.jpg',
                'do_text' => 'Kembalikan baki & alat makan ke rak.',
                'do_sub' => 'Kembalikan baki makanan, piring, dan sendok ke rak pengembalian yang tersedia.',
                'dont_text' => 'Jangan tinggalkan piring kotor di meja makan.',
                'dont_sub' => 'Jangan meninggalkan sisa makanan, bungkus plastik, atau tisu kotor di meja makan.',
                'sort_order' => 10,
                'is_active' => true,
                'type' => 'do',
                'title' => 'Kembalikan baki & alat makan ke rak.',
                'description' => 'Kembalikan baki makanan, piring, dan sendok ke rak pengembalian yang tersedia.',
            ],
            [
                'category' => 'Canteen',
                'image_path' => '/images/facilities-office.jpg',
                'do_text' => 'Antre tertib & ambil porsi secukupnya.',
                'do_sub' => 'Budayakan antre tertib dan ambil porsi makanan secukupnya untuk mencegah mubazir.',
                'dont_text' => 'Jangan menyerobot antrean atau membuang makanan.',
                'dont_sub' => 'Dilarang menyerobot antrean katering atau membuang makanan berlebih.',
                'sort_order' => 11,
                'is_active' => true,
                'type' => 'do',
                'title' => 'Antre tertib & ambil porsi secukupnya.',
                'description' => 'Budayakan antre tertib dan ambil porsi makanan secukupnya untuk mencegah mubazir.',
            ],
            [
                'category' => 'Canteen',
                'image_path' => '/images/hero-office.jpg',
                'do_text' => 'Jaga kebersihan area ruang makan.',
                'do_sub' => 'Lap tumpahan makanan atau minuman kecil secara mandiri demi kenyamanan bersama.',
                'dont_text' => 'Jangan bawa makanan berbau tajam ke meja kerja.',
                'dont_sub' => 'Hindari membawa makanan berbau menyengat ke dalam area kerja terbuka gedung kantor.',
                'sort_order' => 12,
                'is_active' => true,
                'type' => 'do',
                'title' => 'Jaga kebersihan area ruang makan.',
                'description' => 'Lap tumpahan makanan atau minuman kecil secara mandiri demi kenyamanan bersama.',
            ],

            // Safety
            [
                'category' => 'Safety',
                'image_path' => '/images/plant-exterior.jpg',
                'do_text' => 'Gunakan APD wajib di area pabrik (Plant).',
                'do_sub' => 'Gunakan safety shoes, kacamata pelindung, dan rompi saat memasuki area pabrik/plant.',
                'dont_text' => 'Jangan masuk area pabrik tanpa alat pelindung diri.',
                'dont_sub' => 'Dilarang melintasi area produksi tanpa alat pelindung diri (APD) yang sesuai standar.',
                'sort_order' => 13,
                'is_active' => true,
                'type' => 'do',
                'title' => 'Gunakan APD wajib di area pabrik (Plant).',
                'description' => 'Gunakan safety shoes, kacamata pelindung, dan rompi saat memasuki area pabrik/plant.',
            ],
            [
                'category' => 'Safety',
                'image_path' => '/images/mockup-c4.jpg',
                'do_text' => 'Berjalanlah di dalam jalur hijau pejalan kaki.',
                'do_sub' => 'Berjalanlah di dalam garis hijau dan gunakan pegangan tangan saat menaiki/menuruni tangga.',
                'dont_text' => 'Jangan menatap layar ponsel saat berjalan.',
                'dont_sub' => 'Dilarang mengetik ponsel saat melangkah di koridor, tangga, atau area lintasan forklift.',
                'sort_order' => 14,
                'is_active' => true,
                'type' => 'do',
                'title' => 'Berjalanlah di dalam jalur hijau pejalan kaki.',
                'description' => 'Berjalanlah di dalam garis hijau dan gunakan pegangan tangan saat menaiki/menuruni tangga.',
            ],
            [
                'category' => 'Safety',
                'image_path' => '/images/facilities-office.jpg',
                'do_text' => 'Segera laporkan bahaya & potensi insiden.',
                'do_sub' => 'Laporkan potensi bahaya, ceceran oli/air, atau insiden near-miss ke tim HSE segera.',
                'dont_text' => 'Jangan menghalangi APAR atau pintu darurat.',
                'dont_sub' => 'Dilarang menumpuk barang di depan APAR, kotak hydrant, atau pintu darurat.',
                'sort_order' => 15,
                'is_active' => true,
                'type' => 'do',
                'title' => 'Segera laporkan bahaya & potensi insiden.',
                'description' => 'Laporkan potensi bahaya, ceceran oli/air, atau insiden near-miss ke tim HSE segera.',
            ],
        ];

        foreach ($defaults as $item) {
            DosAndDont::create($item);
        }
    }

    /**
     * Display the Office & Plant overview page.
     */
    public function officeAndPlant()
    {
        try {
            $facilities = Facility::orderBy('sort_order')->get();
            $emergencyContacts = EmergencyContact::orderBy('sort_order')->get();
        } catch (\Throwable $e) {
            $facilities = collect();
            $emergencyContacts = collect();
        }

        return $this->renderWithCache('guide.office-and-plant', compact('facilities', 'emergencyContacts'));
    }

    /**
     * Display emergency contacts and procedures.
     */
    public function emergency()
    {
        try {
            $contacts = EmergencyContact::orderBy('sort_order')->get();
        } catch (\Throwable $e) {
            $contacts = collect();
        }
        return $this->renderWithCache('guide.emergency', compact('contacts'));
    }

    /**
     * Display personalized QR Desk Onboarding Journey (or redirect Admin to Desk Manager).
     */
    public function onboarding(Request $request)
    {
        $scannedDesk = null;
        try {
            if ($request->filled('desk')) {
                $scannedDesk = DeskCard::where('desk_number', $request->query('desk'))->first();
            }
        } catch (\Throwable $e) {
        }
        $onboardingSteps = OfficeConceptData::onboardingSteps();
        return $this->renderWithCache('guide.onboarding', compact('onboardingSteps', 'scannedDesk'));
    }

    /**
     * Display Canteen & Dining Services Guide (Concept Slide 1, 6, 8).
     */
    public function canteen()
    {
        $diningFacility = null;
        try {
            $diningFacility = Facility::where('category', 'dining')->orderBy('sort_order')->first();
        } catch (\Throwable $e) {
        }
        $canteenSteps = OfficeConceptData::defaultFacilitySteps('dining', 'Kantin Utama');
        return $this->renderWithCache('guide.canteen', compact('diningFacility', 'canteenSteps'));
    }

    /**
     * Display Visitor Management & Virtual Reception Guide (Concept Slide 6, 8, 10).
     */
    public function visitorGuide()
    {
        $lobbyFacility = null;
        try {
            $lobbyFacility = Facility::where('category', 'service')->orderBy('sort_order')->first();
        } catch (\Throwable $e) {
        }
        $visitorSteps = OfficeConceptData::defaultFacilitySteps('service', 'Tamu & Resepsionis');
        return $this->renderWithCache('guide.visitor', compact('lobbyFacility', 'visitorSteps'));
    }

    /**
     * Display Attendance & Working Hours Guide (Concept Slide 1, 4).
     */
    public function attendance()
    {
        return $this->renderWithCache('guide.attendance');
    }

    /**
     * Display Support & Contact Center (IT, GA, HR & Emergency).
     */
    public function support()
    {
        try {
            $contacts = EmergencyContact::orderBy('sort_order')->get();
        } catch (\Throwable $e) {
            $contacts = collect();
        }
        return $this->renderWithCache('guide.support', compact('contacts'));
    }

    /**
     * Fast global search across all guide resources.
     */
    public function search(Request $request)
    {
        $q = trim((string) $request->input('q', ''));
        if (strlen($q) < 2) {
            return response()->json(['results' => []]);
        }

        $like = config('database.default') === 'pgsql' ? 'ilike' : 'like';
        $searchTerm = '%' . $q . '%';

        $facilities = Facility::where('name', $like, $searchTerm)
            ->orWhere('description', $like, $searchTerm)
            ->take(4)
            ->get(['name', 'slug', 'category', 'floor', 'image_path']);

        $rules = DosAndDont::where('title', $like, $searchTerm)
            ->orWhere('description', $like, $searchTerm)
            ->take(4)
            ->get(['title', 'type', 'category']);

        $zones = OfficeZone::where('name', $like, $searchTerm)
            ->orWhere('code', $like, $searchTerm)
            ->take(4)
            ->get(['name', 'code', 'floor', 'building']);

        return response()->json([
            'facilities' => $facilities,
            'rules' => $rules,
            'zones' => $zones,
        ]);
    }
}
