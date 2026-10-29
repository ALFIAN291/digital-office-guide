<?php

namespace App\Http\Controllers;

use App\Models\DosAndDont;
use App\Models\EmergencyContact;
use App\Models\Facility;
use App\Models\ManagementMessage;
use App\Models\OfficeZone;
use Illuminate\Http\Request;

class GuideController extends Controller
{
    /**
     * Helper to render views with Vercel Edge caching for guest visitors.
     */
    protected function renderWithCache($view, array $data = [])
    {
        $response = response()->view($view, $data);
        if (!auth()->check()) {
            $response->header('Cache-Control', 'public, max-age=60, s-maxage=300, stale-while-revalidate=600');
        } else {
            $response->header('Cache-Control', 'no-cache, private');
        }
        return $response;
    }

    /**
     * Display the main home screen matching the design.
     */
    public function index()
    {
        try {
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
                'title' => 'A Message from Management',
                'sender_name' => 'Management Board',
                'sender_role' => 'PT Akebono Brake Astra Indonesia',
                'content' => "Selamat datang di panduan fasilitas kantor baru Akebono Karawang.\n\nMari kita ciptakan tempat kerja yang nyaman, aman, dan produktif bersama.",
                'summary' => 'As we begin a new chapter at our Karawang office, let us build a safer, more collaborative, and future-ready workplace — together.',
                'image_path' => 'images/management-office.jpg',
            ]);
        }

        return $this->renderWithCache('guide.index', compact(
            'message',
            'facilities',
            'featuredFacilities',
            'emergencyContacts',
            'rulesCount',
            'zonesCount'
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
                'title' => 'A Message from Management',
                'sender_name' => 'Management Board',
                'sender_title' => 'PT Akebono Brake Astra Indonesia',
                'content' => 'Selamat datang di fasilitas kantor Akebono Karawang.',
                'summary' => 'Membangun tempat kerja yang aman, kolaboratif, dan siap menyongsong masa depan.',
            ]);
        }

        return $this->renderWithCache('guide.message', compact('message'));
    }

    /**
     * Display the Facilities page with filters & search.
     * All facilities are passed to view so filtering between categories and floors is instantaneous.
     */
    public function facilities(Request $request)
    {
        try {
            $facilities = Facility::orderBy('sort_order')->get();
        } catch (\Throwable $e) {
            $facilities = collect();
        }
        $matchingRules = collect();

        if ($request->filled('q')) {
            $searchTerm = '%' . $request->q . '%';
            $like = config('database.default') === 'pgsql' ? 'ilike' : 'like';

            try {
                $matchingRules = DosAndDont::where('title', $like, $searchTerm)
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
     * Display single facility details.
     */
    public function facilityDetail($slug)
    {
        try {
            $facility = Facility::where('slug', $slug)->first();
            if (!$facility) {
                return redirect()->route('guide.facilities');
            }
            $related = Facility::where('category', $facility->category)
                ->where('id', '!=', $facility->id)
                ->take(3)
                ->get();
        } catch (\Throwable $e) {
            return redirect()->route('guide.facilities');
        }

        return $this->renderWithCache('guide.facility-detail', compact('facility', 'related'));
    }

    /**
     * Display the Interactive Office Map.
     */
    public function map(Request $request)
    {
        $floor = $request->get('floor', 'Lantai 1');
        try {
            $zones = OfficeZone::where('floor', $floor)->orderBy('sort_order')->get();
            $allZones = OfficeZone::orderBy('sort_order')->get();
        } catch (\Throwable $e) {
            $zones = collect();
            $allZones = collect();
        }

        $floors = [
            'Lantai 1' => 'Gedung Utama - Lantai 1',
            'Lantai 2' => 'Gedung Utama - Lantai 2',
            'Ground Floor' => 'Plant 1 & Plant 2 (Pabrik)',
        ];

        return $this->renderWithCache('guide.map', compact('zones', 'floor', 'floors', 'allZones'));
    }

    /**
     * Display the Dos and Don'ts guideline page.
     * Guidelines are formatted in paired DO & DON'T cards matching the official mockup.
     */
    public function dosAndDonts(Request $request)
    {
        $categories = [
            'General' => 'General Etiquette',
            'Meeting Room' => 'Meeting Room Etiquette',
            'Workspace' => 'Workspace Etiquette',
            'Canteen' => 'Canteen Etiquette',
            'Safety' => 'Safety Etiquette',
        ];

        $curatedPairs = [
            // General
            [
                'id' => 'gen-1',
                'category' => 'General',
                'image' => asset('images/hero-office.jpg'),
                'do' => 'Keep shared spaces clean.',
                'do_sub' => 'Rapikan area kerja dan jaga kebersihan fasilitas bersama.',
                'dont' => 'Leave personal items behind.',
                'dont_sub' => 'Jangan meninggalkan barang pribadi atau sampah di area umum.',
            ],
            [
                'id' => 'gen-2',
                'category' => 'General',
                'image' => asset('images/meeting-room.jpg'),
                'do' => 'Respect meeting schedules.',
                'do_sub' => 'Hadir tepat waktu dan selesaikan rapat sesuai durasi.',
                'dont' => 'Leave devices running.',
                'dont_sub' => 'Jangan biarkan proyektor, lampu, atau monitor menyala setelah rapat.',
            ],
            [
                'id' => 'gen-3',
                'category' => 'General',
                'image' => asset('images/facilities-office.jpg'),
                'do' => 'Dispose of waste properly.',
                'do_sub' => 'Pilah sampah organik, anorganik, dan residu pada tempatnya.',
                'dont' => 'Eat outside designated areas.',
                'dont_sub' => 'Hindari makan makanan berat di luar kantin atau pantry.',
            ],

            // Meeting Room
            [
                'id' => 'mr-1',
                'category' => 'Meeting Room',
                'image' => asset('images/meeting-room.jpg'),
                'do' => 'Respect meeting schedules.',
                'do_sub' => 'Pesan ruangan sesuai kapasitas peserta dan batalkan jika tidak jadi digunakan.',
                'dont' => 'Leave devices running.',
                'dont_sub' => 'Jangan biarkan AC, proyektor, dan layar video conference terus menyala.',
            ],
            [
                'id' => 'mr-2',
                'category' => 'Meeting Room',
                'image' => asset('images/mockup-c2.jpg'),
                'do' => 'Clean whiteboard & return chairs.',
                'do_sub' => 'Hapus papan tulis dan rapikan posisi kursi untuk tim pengguna selanjutnya.',
                'dont' => 'Leave food scraps & used cups.',
                'dont_sub' => 'Dilarang meninggalkan gelas kotor, sisa konsumsi, atau sampah berkas di meja.',
            ],
            [
                'id' => 'mr-3',
                'category' => 'Meeting Room',
                'image' => asset('images/mockup-c1.jpg'),
                'do' => 'Silence mobile phones.',
                'do_sub' => 'Ubah nada dering ponsel ke mode hening (vibrate) selama diskusi berlangsung.',
                'dont' => 'Conduct loud side-conversations.',
                'dont_sub' => 'Hindari berbisik keras atau menerima telepon pribadi di tengah jalannya meeting.',
            ],

            // Workspace
            [
                'id' => 'ws-1',
                'category' => 'Workspace',
                'image' => asset('images/hero-office.jpg'),
                'do' => 'Implement 5S & Clean Desk Policy.',
                'do_sub' => 'Rapikan meja dan simpan dokumen sebelum meninggalkan kantor setiap sore.',
                'dont' => 'Leave confidential items unlocked.',
                'dont_sub' => 'Jangan meninggalkan dokumen rahasia, ID card, atau laptop tanpa dikunci (Win+L).',
            ],
            [
                'id' => 'ws-2',
                'category' => 'Workspace',
                'image' => asset('images/facilities-office.jpg'),
                'do' => 'Use phone booth for long calls.',
                'do_sub' => 'Gunakan private phone booth untuk percakapan intensif atau panggilan video.',
                'dont' => 'Talk loudly on speakerphones.',
                'dont_sub' => 'Hindari berbicara keras atau menggunakan speakerphone di area kerja terbuka.',
            ],
            [
                'id' => 'ws-3',
                'category' => 'Workspace',
                'image' => asset('images/mockup-mgmt.jpg'),
                'do' => 'Keep aisles & walkways clear.',
                'do_sub' => 'Pastikan jalur evakuasi dan bawah meja kerja bebas dari hambatan barang/kabel.',
                'dont' => 'Run loose cords across walkways.',
                'dont_sub' => 'Dilarang melintangkan kabel listrik sembarangan yang berisiko tersandung.',
            ],

            // Canteen
            [
                'id' => 'cnt-1',
                'category' => 'Canteen',
                'image' => asset('images/mockup-c3.jpg'),
                'do' => 'Return trays & cutlery to racks.',
                'do_sub' => 'Kembalikan baki makanan, piring, dan sendok ke rak pengembalian yang tersedia.',
                'dont' => 'Leave dirty tableware on tables.',
                'dont_sub' => 'Jangan meninggalkan sisa makanan, bungkus plastik, atau tisu kotor di meja makan.',
            ],
            [
                'id' => 'cnt-2',
                'category' => 'Canteen',
                'image' => asset('images/facilities-office.jpg'),
                'do' => 'Queue orderly & take mindful portions.',
                'do_sub' => 'Budayakan antre tertib dan ambil porsi makanan secukupnya untuk mencegah mubazir.',
                'dont' => 'Cut queues or waste food.',
                'dont_sub' => 'Dilarang menyerobot antrean katering atau membuang makanan berlebih.',
            ],
            [
                'id' => 'cnt-3',
                'category' => 'Canteen',
                'image' => asset('images/hero-office.jpg'),
                'do' => 'Maintain dining cleanliness.',
                'do_sub' => 'Lap tumpahan makanan atau minuman kecil secara mandiri demi kenyamanan bersama.',
                'dont' => 'Bring pungent food to office desks.',
                'dont_sub' => 'Hindari membawa makanan berbau menyengat ke dalam area kerja terbuka gedung kantor.',
            ],

            // Safety
            [
                'id' => 'saf-1',
                'category' => 'Safety',
                'image' => asset('images/plant-exterior.jpg'),
                'do' => 'Wear required PPE in plant zones.',
                'do_sub' => 'Gunakan safety shoes, kacamata pelindung, dan rompi saat memasuki area pabrik/plant.',
                'dont' => 'Enter plant without safety gear.',
                'dont_sub' => 'Dilarang melintasi area produksi tanpa alat pelindung diri (APD) yang sesuai standar.',
            ],
            [
                'id' => 'saf-2',
                'category' => 'Safety',
                'image' => asset('images/mockup-c4.jpg'),
                'do' => 'Walk within green pedestrian lanes.',
                'do_sub' => 'Berjalanlah di dalam garis hijau dan gunakan pegangan tangan saat menaiki/menuruni tangga.',
                'dont' => 'Look down at phones while walking.',
                'dont_sub' => 'Dilarang mengetik ponsel saat melangkah di koridor, tangga, atau area lintasan forklift.',
            ],
            [
                'id' => 'saf-3',
                'category' => 'Safety',
                'image' => asset('images/facilities-office.jpg'),
                'do' => 'Report hazards & near-misses.',
                'do_sub' => 'Laporkan potensi bahaya, ceceran oli/air, atau insiden near-miss ke tim HSE segera.',
                'dont' => 'Block fire extinguishers or exits.',
                'dont_sub' => 'Dilarang menumpuk barang di depan APAR, kotak hydrant, atau pintu darurat.',
            ],
        ];

        // Check if DB has any rules
        try {
            $allRules = DosAndDont::orderBy('sort_order')->get();
        } catch (\Throwable $e) {
            $allRules = collect();
        }

        $initialCategory = $request->get('category', 'General');
        $initialQuery = $request->get('q', '');

        return $this->renderWithCache('guide.dos-and-donts', [
            'pairs' => $curatedPairs,
            'categories' => $categories,
            'rules' => $allRules,
            'initialCategory' => $initialCategory,
            'initialQuery' => $initialQuery,
        ]);
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
     * Fast global search across all guide resources.
     */
    public function search(Request $request)
    {
        $q = trim($request->get('q', ''));
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
