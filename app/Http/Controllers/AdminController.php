<?php

namespace App\Http\Controllers;

use App\Models\DosAndDont;
use App\Models\EmergencyContact;
use App\Models\Facility;
use App\Models\HomeSetting;
use App\Models\ManagementMessage;
use App\Models\OfficeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Admin Dashboard Overview.
     */
    public function dashboard()
    {
        $settings = HomeSetting::current();
        $message = ManagementMessage::where('is_active', true)->first();
        $stats = [
            'facilities_count' => Facility::count(),
            'rules_count' => DosAndDont::count(),
            'dos_count' => DosAndDont::where('type', 'do')->count(),
            'donts_count' => DosAndDont::where('type', 'dont')->count(),
            'zones_count' => OfficeZone::count(),
            'contacts_count' => EmergencyContact::count(),
        ];

        return view('admin.dashboard', compact('settings', 'message', 'stats'));
    }

    /**
     * Form to edit Home & Hero content ("konten yang diawal").
     */
    public function editHome()
    {
        $settings = HomeSetting::current();
        return view('admin.home-editor', compact('settings'));
    }

    /**
     * Update Home & Hero content.
     */
    public function updateHome(Request $request)
    {
        $settings = HomeSetting::current();

        $validated = $request->validate([
            'office_title' => ['required', 'string', 'max:100'],
            'office_subtitle' => ['required', 'string', 'max:100'],
            'hero_badge' => ['required', 'string', 'max:150'],
            'hero_title_line1' => ['required', 'string', 'max:100'],
            'hero_title_line2' => ['required', 'string', 'max:100'],
            'hero_tagline' => ['required', 'string', 'max:255'],
            'hero_image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'explore_title' => ['required', 'string', 'max:150'],
            
            // Card 1: Office & Plant
            'card_office_title' => ['required', 'string', 'max:100'],
            'card_office_badge' => ['required', 'string', 'max:100'],
            'card_office_image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            
            // Card 2: Facilities
            'card_facilities_title' => ['required', 'string', 'max:100'],
            'card_facilities_badge' => ['required', 'string', 'max:100'],
            'card_facilities_image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],

            // Card 3: Office Map
            'card_map_title' => ['required', 'string', 'max:100'],
            'card_map_badge' => ['required', 'string', 'max:100'],
            'card_map_image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],

            // Card 4: Dos & Don'ts
            'card_rules_title' => ['required', 'string', 'max:100'],
            'card_rules_badge' => ['required', 'string', 'max:100'],
            'card_rules_image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],

            'footnote_text' => ['required', 'string', 'max:255'],
            'safety_badge' => ['nullable', 'string', 'max:150'],
            'safety_title' => ['nullable', 'string', 'max:150'],
            'safety_description' => ['nullable', 'string'],
        ]);

        // Handle Image Uploads
        $uploadPath = public_path('images/uploads');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        if ($request->hasFile('hero_image_file')) {
            $file = $request->file('hero_image_file');
            $filename = 'hero_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $validated['hero_image'] = '/images/uploads/' . $filename;
        }

        if ($request->hasFile('card_office_image_file')) {
            $file = $request->file('card_office_image_file');
            $filename = 'card_office_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $validated['card_office_image'] = '/images/uploads/' . $filename;
        }

        if ($request->hasFile('card_facilities_image_file')) {
            $file = $request->file('card_facilities_image_file');
            $filename = 'card_fac_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $validated['card_facilities_image'] = '/images/uploads/' . $filename;
        }

        if ($request->hasFile('card_map_image_file')) {
            $file = $request->file('card_map_image_file');
            $filename = 'card_map_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $validated['card_map_image'] = '/images/uploads/' . $filename;
        }

        if ($request->hasFile('card_rules_image_file')) {
            $file = $request->file('card_rules_image_file');
            $filename = 'card_rules_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $validated['card_rules_image'] = '/images/uploads/' . $filename;
        }

        $settings->update($validated);

        return redirect()->route('admin.home.edit')
            ->with('success', 'Konten Beranda dan Tampilan Awal berhasil diperbarui!');
    }

    /**
     * Form to edit "A Message from Management".
     */
    public function editMessage()
    {
        $message = ManagementMessage::where('is_active', true)->first() ?? new ManagementMessage();
        return view('admin.message-editor', compact('message'));
    }

    /**
     * Update "A Message from Management".
     */
    public function updateMessage(Request $request)
    {
        $message = ManagementMessage::where('is_active', true)->first();
        if (!$message) {
            $message = new ManagementMessage();
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'sender_name' => ['required', 'string', 'max:255'],
            'sender_role' => ['required', 'string', 'max:255'],
            'summary' => ['required', 'string'],
            'content' => ['required', 'string'],
            'quote' => ['nullable', 'string', 'max:255'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ]);

        if ($request->hasFile('image_file')) {
            $uploadPath = public_path('images/uploads');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $file = $request->file('image_file');
            $filename = 'management_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $validated['image_path'] = '/images/uploads/' . $filename;
        }

        $message->fill($validated);
        $message->is_active = true;
        $message->save();

        return redirect()->route('admin.message.edit')
            ->with('success', 'Pesan Manajemen (A Message from Management) berhasil diperbarui!');
    }

    /**
     * List all facilities for admin.
     */
    public function facilities()
    {
        $facilities = Facility::orderBy('sort_order')->get();
        return view('admin.facilities.index', compact('facilities'));
    }

    /**
     * Show create facility form.
     */
    public function createFacility()
    {
        return view('admin.facilities.create');
    }

    /**
     * Store new facility.
     */
    public function storeFacility(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string'],
            'floor' => ['required', 'string'],
            'location_detail' => ['nullable', 'string', 'max:255'],
            'capacity' => ['nullable', 'string', 'max:100'],
            'operating_hours' => ['nullable', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'guidelines' => ['nullable', 'string'],
            'amenities_text' => ['nullable', 'string'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . rand(100, 999);
        $validated['is_featured'] = $request->boolean('is_featured');

        if (!empty($validated['amenities_text'])) {
            $validated['amenities'] = array_values(array_filter(array_map('trim', explode(',', $validated['amenities_text']))));
        }

        if ($request->hasFile('image_file')) {
            $uploadPath = public_path('images/uploads');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $file = $request->file('image_file');
            $filename = 'facility_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $validated['image_path'] = '/images/uploads/' . $filename;
        }

        Facility::create($validated);

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Fasilitas baru berhasil ditambahkan!');
    }

    /**
     * Show edit facility form.
     */
    public function editFacility($id)
    {
        $facility = Facility::findOrFail($id);
        return view('admin.facilities.edit', compact('facility'));
    }

    /**
     * Update existing facility.
     */
    public function updateFacility(Request $request, $id)
    {
        $facility = Facility::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string'],
            'floor' => ['required', 'string'],
            'location_detail' => ['nullable', 'string', 'max:255'],
            'capacity' => ['nullable', 'string', 'max:100'],
            'operating_hours' => ['nullable', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'guidelines' => ['nullable', 'string'],
            'amenities_text' => ['nullable', 'string'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        if (!empty($validated['amenities_text'])) {
            $validated['amenities'] = array_values(array_filter(array_map('trim', explode(',', $validated['amenities_text']))));
        }

        if ($request->hasFile('image_file')) {
            $uploadPath = public_path('images/uploads');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $file = $request->file('image_file');
            $filename = 'facility_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $validated['image_path'] = '/images/uploads/' . $filename;
        }

        $facility->update($validated);

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Fasilitas "' . $facility->name . '" berhasil diperbarui!');
    }

    /**
     * Delete a facility.
     */
    public function deleteFacility($id)
    {
        $facility = Facility::findOrFail($id);
        $name = $facility->name;
        $facility->delete();

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Fasilitas "' . $name . '" telah dihapus.');
    }

    /**
     * List all Dos & Don'ts for admin.
     */
    public function dosAndDonts()
    {
        $rules = DosAndDont::orderBy('category')->orderBy('sort_order')->get();
        return view('admin.rules.index', compact('rules'));
    }

    /**
     * Show create rule form.
     */
    public function createRule()
    {
        return view('admin.rules.create');
    }

    /**
     * Store new rule.
     */
    public function storeRule(Request $request)
    {
        $validated = $request->validate([
            'category' => ['required', 'string'],
            'type' => ['required', 'in:do,dont'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'tip_or_consequence' => ['nullable', 'string'],
        ]);

        DosAndDont::create($validated);

        return redirect()->route('admin.rules.index')
            ->with('success', 'Pedoman ' . strtoupper($validated['type']) . ' berhasil ditambahkan!');
    }

    /**
     * Show edit rule form.
     */
    public function editRule($id)
    {
        $rule = DosAndDont::findOrFail($id);
        return view('admin.rules.edit', compact('rule'));
    }

    /**
     * Update existing rule.
     */
    public function updateRule(Request $request, $id)
    {
        $rule = DosAndDont::findOrFail($id);

        $validated = $request->validate([
            'category' => ['required', 'string'],
            'type' => ['required', 'in:do,dont'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'tip_or_consequence' => ['nullable', 'string'],
        ]);

        $rule->update($validated);

        return redirect()->route('admin.rules.index')
            ->with('success', 'Pedoman "' . $rule->title . '" berhasil diperbarui!');
    }

    /**
     * Delete a rule.
     */
    public function deleteRule($id)
    {
        $rule = DosAndDont::findOrFail($id);
        $rule->delete();

        return redirect()->route('admin.rules.index')
            ->with('success', 'Pedoman telah dihapus.');
    }

    /**
     * Manage emergency contacts.
     */
    public function emergencyContacts()
    {
        $contacts = EmergencyContact::orderBy('sort_order')->get();
        return view('admin.emergency.index', compact('contacts'));
    }

    /**
     * Update emergency contact.
     */
    public function updateEmergencyContact(Request $request, $id)
    {
        $contact = EmergencyContact::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:100'],
            'extension' => ['nullable', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:255'],
            'is_hotline' => ['nullable', 'boolean'],
        ]);

        $validated['is_hotline'] = $request->boolean('is_hotline');
        $contact->update($validated);

        return redirect()->route('admin.emergency.index')
            ->with('success', 'Kontak darurat "' . $contact->name . '" berhasil diperbarui!');
    }

    /**
     * Change admin password form.
     */
    public function editPassword()
    {
        return view('admin.password');
    }

    /**
     * Update admin password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.current_password' => 'Password lama tidak sesuai.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($validated['new_password']);
        $user->save();

        return redirect()->route('admin.password.edit')
            ->with('success', 'Password Anda berhasil diperbarui!');
    }
}

