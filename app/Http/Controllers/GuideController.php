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

        return view('guide.index', compact(
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

        return view('guide.message', compact('message'));
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

        return view('guide.facilities', compact('facilities', 'categories', 'floors', 'matchingRules'));
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

        return view('guide.facility-detail', compact('facility', 'related'));
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

        return view('guide.map', compact('zones', 'floor', 'floors', 'allZones'));
    }

    /**
     * Display the Dos and Don'ts guideline page.
     * All rules are passed to view so filtering between categories and DO/DONT is instantaneous (zero loading).
     */
    public function dosAndDonts(Request $request)
    {
        try {
            $allRules = DosAndDont::orderBy('sort_order')->get();
        } catch (\Throwable $e) {
            $allRules = collect();
        }

        $categories = [
            'all' => 'Semua Kategori',
            'HSE & Keselamatan' => 'HSE & Keselamatan',
            'Etiket Kerja & Lingkungan' => 'Etiket Kerja & Lingkungan',
            'Keamanan Informasi & TI' => 'Keamanan Informasi & TI',
        ];

        $counts = [
            'total' => $allRules->count(),
            'dos' => $allRules->where('type', 'do')->count(),
            'donts' => $allRules->where('type', 'dont')->count(),
        ];

        $initialType = $request->get('type', 'all');
        $initialCategory = $request->get('category', 'all');
        $initialQuery = $request->get('q', '');

        return view('guide.dos-and-donts', [
            'rules' => $allRules,
            'categories' => $categories,
            'counts' => $counts,
            'initialType' => $initialType,
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

        return view('guide.office-and-plant', compact('facilities', 'emergencyContacts'));
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
        return view('guide.emergency', compact('contacts'));
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
