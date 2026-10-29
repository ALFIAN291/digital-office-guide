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
        $rulesCount = DosAndDont::count();
        $dosCount = DosAndDont::whereNotNull('do_text')->where('do_text', '!=', '')->count();
        $dontsCount = DosAndDont::whereNotNull('dont_text')->where('dont_text', '!=', '')->count();
        if ($dosCount === 0 && $rulesCount > 0) $dosCount = $rulesCount;
        if ($dontsCount === 0 && $rulesCount > 0) $dontsCount = $rulesCount;

        $stats = [
            'facilities_count' => Facility::count(),
            'rules_count' => $rulesCount,
            'dos_count' => $dosCount,
            'donts_count' => $dontsCount,
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
        $message = ManagementMessage::where('is_active', true)->first() ?? new ManagementMessage();
        return view('admin.home-editor', compact('settings', 'message'));
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
            'hero_height' => ['nullable', 'in:pendek,sedang,besar'],
            'message_height' => ['nullable', 'in:pendek,sedang,besar'],
            'message_display_mode' => ['nullable', 'in:popup,card'],
            'message_auto_popup' => ['nullable'],
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

        // Handle Image Uploads Safely
        if ($request->hasFile('hero_image_file')) {
            $validated['hero_image'] = $this->handleImageUpload($request, 'hero_image_file', 'hero', $settings->hero_image);
        }

        if ($request->hasFile('card_office_image_file')) {
            $validated['card_office_image'] = $this->handleImageUpload($request, 'card_office_image_file', 'card_office', $settings->card_office_image);
        }

        if ($request->hasFile('card_facilities_image_file')) {
            $validated['card_facilities_image'] = $this->handleImageUpload($request, 'card_facilities_image_file', 'card_fac', $settings->card_facilities_image);
        }

        if ($request->hasFile('card_map_image_file')) {
            $validated['card_map_image'] = $this->handleImageUpload($request, 'card_map_image_file', 'card_map', $settings->card_map_image);
        }

        if ($request->hasFile('card_rules_image_file')) {
            $validated['card_rules_image'] = $this->handleImageUpload($request, 'card_rules_image_file', 'card_rules', $settings->card_rules_image);
        }

        $validated['message_auto_popup'] = $request->has('message_auto_popup');

        $settings->update($validated);

        if ($request->has('message_badge_label') || $request->has('message_subtitle')) {
            $msg = ManagementMessage::where('is_active', true)->first();
            if ($msg) {
                if ($request->has('message_badge_label')) $msg->badge_label = $request->input('message_badge_label');
                if ($request->has('message_subtitle')) $msg->subtitle = $request->input('message_subtitle');
                $msg->save();
            }
        }

        return redirect()->route('admin.home.edit')
            ->with('success', 'Konten Beranda dan Tampilan Awal berhasil diperbarui!');
    }

    /**
     * Form to edit "A Message from Management".
     */
    public function editMessage()
    {
        $message = ManagementMessage::where('is_active', true)->first() ?? new ManagementMessage();
        $settings = HomeSetting::current();
        return view('admin.message-editor', compact('message', 'settings'));
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
            'badge_label' => ['nullable', 'string', 'max:100'],
            'subtitle' => ['nullable', 'string', 'max:150'],
            'sender_name' => ['required', 'string', 'max:255'],
            'sender_role' => ['required', 'string', 'max:255'],
            'summary' => ['required', 'string'],
            'content' => ['required', 'string'],
            'quote' => ['nullable', 'string', 'max:255'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'message_height' => ['nullable', 'in:pendek,sedang,besar'],
            'message_display_mode' => ['nullable', 'in:popup,card'],
            'message_auto_popup' => ['nullable'],
        ]);

        $settingsUpdates = [];
        if ($request->filled('message_height')) {
            $settingsUpdates['message_height'] = $request->input('message_height');
        }
        if ($request->filled('message_display_mode')) {
            $settingsUpdates['message_display_mode'] = $request->input('message_display_mode');
        }
        $settingsUpdates['message_auto_popup'] = $request->has('message_auto_popup');
        HomeSetting::current()->update($settingsUpdates);

        if ($request->hasFile('image_file')) {
            $imagePath = $this->handleImageUpload($request, 'image_file', 'management', $message->image_path);
            if ($imagePath) {
                $validated['image_path'] = $imagePath;
            }
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
        } else {
            $validated['amenities'] = [];
        }

        if ($request->hasFile('image_file')) {
            $imagePath = $this->handleImageUpload($request, 'image_file', 'facility');
            if ($imagePath) {
                $validated['image_path'] = $imagePath;
            }
        }

        unset($validated['amenities_text'], $validated['image_file']);

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
        } else {
            $validated['amenities'] = [];
        }

        if ($request->hasFile('image_file')) {
            $imagePath = $this->handleImageUpload($request, 'image_file', 'facility', $facility->image_path);
            if ($imagePath) {
                $validated['image_path'] = $imagePath;
            }
        }

        unset($validated['amenities_text'], $validated['image_file']);

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
        $categories = ['General', 'Meeting Room', 'Workspace', 'Canteen', 'Safety'];
        return view('admin.rules.create', compact('categories'));
    }

    /**
     * Store new paired rule.
     */
    public function storeRule(Request $request)
    {
        $validated = $request->validate([
            'category' => ['required', 'string', 'max:100'],
            'do_text' => ['required', 'string', 'max:500'],
            'do_sub' => ['nullable', 'string', 'max:1000'],
            'dont_text' => ['required', 'string', 'max:500'],
            'dont_sub' => ['nullable', 'string', 'max:1000'],
            'image_file' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $imagePath = $this->handleImageUpload($request, 'image_file', 'rule');

        DosAndDont::create([
            'category' => $validated['category'],
            'image_path' => $imagePath ?: '/images/hero-office.jpg',
            'do_text' => $validated['do_text'],
            'do_sub' => $validated['do_sub'] ?? null,
            'dont_text' => $validated['dont_text'],
            'dont_sub' => $validated['dont_sub'] ?? null,
            'sort_order' => (int) ($request->input('sort_order', 0) ?? 0),
            'is_active' => true,
            // Compatibility fields
            'type' => 'do',
            'title' => $validated['do_text'],
            'description' => $validated['do_sub'] ?? $validated['do_text'],
        ]);

        return redirect()->route('admin.rules.index')
            ->with('success', 'Pedoman (DO & DON\'T) berhasil ditambahkan!');
    }

    /**
     * Show edit rule form.
     */
    public function editRule($id)
    {
        $rule = DosAndDont::findOrFail($id);
        $categories = ['General', 'Meeting Room', 'Workspace', 'Canteen', 'Safety'];
        return view('admin.rules.edit', compact('rule', 'categories'));
    }

    /**
     * Update existing paired rule.
     */
    public function updateRule(Request $request, $id)
    {
        $rule = DosAndDont::findOrFail($id);

        $validated = $request->validate([
            'category' => ['required', 'string', 'max:100'],
            'do_text' => ['required', 'string', 'max:500'],
            'do_sub' => ['nullable', 'string', 'max:1000'],
            'dont_text' => ['required', 'string', 'max:500'],
            'dont_sub' => ['nullable', 'string', 'max:1000'],
            'image_file' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $imagePath = $this->handleImageUpload($request, 'image_file', 'rule', $rule->image_path);

        $rule->update([
            'category' => $validated['category'],
            'image_path' => $imagePath,
            'do_text' => $validated['do_text'],
            'do_sub' => $validated['do_sub'] ?? null,
            'dont_text' => $validated['dont_text'],
            'dont_sub' => $validated['dont_sub'] ?? null,
            'sort_order' => (int) ($request->input('sort_order', 0) ?? 0),
            'is_active' => $request->has('is_active') ? (bool) $request->input('is_active') : true,
            // Compatibility fields
            'title' => $validated['do_text'],
            'description' => $validated['do_sub'] ?? $validated['do_text'],
        ]);

        return redirect()->route('admin.rules.index')
            ->with('success', 'Pedoman "' . $rule->do_text . '" berhasil diperbarui!');
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

    /**
     * Safely handle image upload across both local environment and Vercel serverless.
     * When running on Vercel (read-only filesystem), compresses/converts the image to a base64 Data URI.
     */
    protected function handleImageUpload(Request $request, string $fieldName, string $prefix, ?string $currentPath = null): ?string
    {
        if (!$request->hasFile($fieldName)) {
            return $currentPath;
        }

        $file = $request->file($fieldName);
        if (!$file || !$file->isValid()) {
            return $currentPath;
        }

        $isVercel = isset($_SERVER['VERCEL']) || isset($_ENV['VERCEL']) || getenv('VERCEL');

        // On Vercel serverless, store directly as base64 Data URI into database
        if ($isVercel) {
            $mime = $file->getMimeType() ?: 'image/jpeg';
            $data = base64_encode(file_get_contents($file->getRealPath()));
            return "data:{$mime};base64,{$data}";
        }

        // On local, try saving to public/images/uploads
        try {
            $uploadPath = public_path('images/uploads');
            if (!file_exists($uploadPath)) {
                @mkdir($uploadPath, 0755, true);
            }
            $filename = $prefix . '_' . time() . '_' . rand(100, 999) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            return '/images/uploads/' . $filename;
        } catch (\Throwable $e) {
            // Fallback to base64 if filesystem is read-only or permission denied
            $mime = $file->getMimeType() ?: 'image/jpeg';
            $data = base64_encode(file_get_contents($file->getRealPath()));
            return "data:{$mime};base64,{$data}";
        }
    }
}

