<?php

namespace App\Support;

use App\Models\Facility;

class OfficeConceptData
{
    /**
     * Six onboarding journey stages synchronized with sidebar & QR onboarding widget.
     */
    public static function onboardingSteps(): array
    {
        return [
            [
                'number' => '01',
                'key' => 'building',
                'title' => 'Explore the Building',
                'subtitle' => 'Office layout, plant zones & movement guide',
                'route' => 'guide.office-and-plant',
                'matches' => ['guide.office-and-plant', 'guide.map'],
                'color' => 'sky',
                'icon' => 'building',
            ],
            [
                'number' => '02',
                'key' => 'facilities',
                'title' => 'Facility Guide',
                'subtitle' => 'Meeting rooms, booking SSO & 5-step how-to',
                'route' => 'guide.facilities',
                'matches' => ['guide.facilities', 'guide.facility.detail'],
                'color' => 'cyan',
                'icon' => 'grid',
            ],
            [
                'number' => '03',
                'key' => 'safety',
                'title' => 'Rules & Safety',
                'subtitle' => 'Workplace Dos & Don\'ts, 5S & PPE standards',
                'route' => 'guide.dos-and-donts',
                'matches' => ['guide.dos-and-donts', 'guide.emergency'],
                'color' => 'emerald',
                'icon' => 'shield',
            ],
            [
                'number' => '04',
                'key' => 'canteen',
                'title' => 'Canteen & Services',
                'subtitle' => 'Cashless Tap ID, shift hours & dining rules',
                'route' => 'guide.canteen',
                'matches' => ['guide.canteen'],
                'color' => 'rose',
                'icon' => 'utensils',
            ],
            [
                'number' => '05',
                'key' => 'attendance',
                'title' => 'Attendance Guide',
                'subtitle' => 'Tap gate, shift schedule & leave portal',
                'route' => 'guide.attendance',
                'matches' => ['guide.attendance'],
                'color' => 'blue',
                'icon' => 'clock',
            ],
            [
                'number' => '06',
                'key' => 'support',
                'title' => 'Support & Contact',
                'subtitle' => 'IT Helpdesk, GA, HR & 24/7 Emergency SOS',
                'route' => 'guide.support',
                'matches' => ['guide.support'],
                'color' => 'indigo',
                'icon' => 'headset',
            ],
        ];
    }

    /**
     * Video Management chapters matching Concept Slide 2 (1:18 overview video).
     */
    public static function defaultVideoChapters(): array
    {
        return [
            [
                'id' => 1,
                'time' => '0:00 - 0:10',
                'seconds' => 0,
                'title' => 'Opening',
                'desc' => 'Company logo, new office building, welcome scene',
                'image' => '/images/plant-exterior.jpg',
                'tag' => 'New Office Building',
                'sub' => 'Modern and Comfortable',
                'link_route' => 'guide.office-and-plant',
            ],
            [
                'id' => 2,
                'time' => '0:10 - 0:30',
                'seconds' => 10,
                'title' => 'Welcome Message',
                'desc' => 'Message from Management about the relocation and future vision',
                'image' => '/images/management-office.jpg',
                'tag' => 'Management Vision',
                'sub' => 'People • Safety • Growth',
                'link_route' => 'guide.message',
            ],
            [
                'id' => 3,
                'time' => '0:30 - 0:45',
                'seconds' => 30,
                'title' => 'New Office & Plant',
                'desc' => 'Show new office building, plant area, and key facilities',
                'image' => '/images/hero-office.jpg',
                'tag' => 'Office Area',
                'sub' => 'Collaborative Workspace',
                'link_route' => 'guide.map',
            ],
            [
                'id' => 4,
                'time' => '0:45 - 1:00',
                'seconds' => 45,
                'title' => 'Better Workplace',
                'desc' => 'Safe, comfortable, and efficient working environment',
                'image' => '/images/meeting-room.jpg',
                'tag' => 'Meeting Room',
                'sub' => 'For Better Collaboration',
                'link_route' => 'guide.facilities',
            ],
            [
                'id' => 5,
                'time' => '1:00 - 1:15',
                'seconds' => 60,
                'title' => 'Together for the Future',
                'desc' => 'Employees, teamwork, and new opportunities across Karawang plant',
                'image' => '/images/facilities-office.jpg',
                'tag' => 'Canteen & Plant',
                'sub' => 'Healthy & Sustainable',
                'link_route' => 'guide.canteen',
            ],
            [
                'id' => 6,
                'time' => '1:15 - 1:18',
                'seconds' => 75,
                'title' => 'Closing',
                'desc' => 'Thank you and welcome message — Moving Together',
                'image' => '/images/floorplan-preview.jpg',
                'tag' => 'Plant Area',
                'sub' => 'Advanced & Sustainable',
                'link_route' => 'guide.dos-and-donts',
            ],
        ];
    }

    /**
     * Five bottom quick scene highlights for Video Message strip.
     */
    public static function videoSceneStrip(): array
    {
        return [
            ['title' => 'New Office Building', 'subtitle' => 'Modern and Comfortable', 'image' => '/images/plant-exterior.jpg', 'chapter' => 0, 'route' => 'guide.office-and-plant'],
            ['title' => 'Office Area', 'subtitle' => 'Collaborative Workspace', 'image' => '/images/facilities-office.jpg', 'chapter' => 2, 'route' => 'guide.map'],
            ['title' => 'Meeting Room', 'subtitle' => 'For Better Collaboration', 'image' => '/images/meeting-room.jpg', 'chapter' => 3, 'route' => 'guide.facilities'],
            ['title' => 'Canteen', 'subtitle' => 'Healthy & Convenient', 'image' => '/images/management-office.jpg', 'chapter' => 4, 'route' => 'guide.canteen'],
            ['title' => 'Plant Area', 'subtitle' => 'Advanced & Sustainable', 'image' => '/images/hero-office.jpg', 'chapter' => 4, 'route' => 'guide.office-and-plant'],
        ];
    }

    /**
     * Default 5-step "How to Use" workflow per facility category.
     */
    public static function defaultFacilitySteps(string $category, string $facilityName = ''): array
    {
        return match ($category) {
            'meeting' => [
                ['step' => 1, 'title' => 'Book via SSO Portal', 'badge' => 'SSO Portal', 'desc' => 'Reserve the meeting room through the Company SSO Portal (Meeting Room System).', 'preview_title' => 'SSO Portal', 'preview_status' => 'Booking Confirmed'],
                ['step' => 2, 'title' => 'Check Reservation on Room Tablet', 'badge' => 'Room Tablet', 'desc' => 'At the room, check the room tablet to see the current schedule and reservation status (Available / In Use).', 'preview_title' => 'Room Display', 'preview_status' => 'AVAILABLE / IN USE'],
                ['step' => 3, 'title' => 'Connect', 'badge' => 'HDMI / Wireless', 'desc' => 'Connect your laptop to the room display (HDMI or wireless casting).', 'preview_title' => 'Connect to Display', 'preview_status' => 'HDMI / Wireless'],
                ['step' => 4, 'title' => 'Start', 'badge' => 'AV & VC Ready', 'desc' => 'Start your meeting, and use the camera, microphone, and speaker as needed.', 'preview_title' => 'Video Conference', 'preview_status' => 'Active Call'],
                ['step' => 5, 'title' => 'Finish', 'badge' => '5S Reset', 'desc' => 'End the meeting, disconnect your device, and leave the room ready for the next user.', 'preview_title' => 'Meeting Finished', 'preview_status' => 'Check Out OK'],
            ],
            'dining' => [
                ['step' => 1, 'title' => 'Check Daily Menu & Hours', 'badge' => '11:00 - 14:00', 'desc' => 'Review today\'s balanced menu board and follow your department shift slot.', 'preview_title' => 'Menu Hari Ini', 'preview_status' => 'Shift Queue'],
                ['step' => 2, 'title' => 'Wash Hands First', 'badge' => 'Hygiene Station', 'desc' => 'Use the automatic sensor sinks and hand sanitizer at the canteen entrance.', 'preview_title' => 'Sanitasi Tangan', 'preview_status' => 'Sensor Ready'],
                ['step' => 3, 'title' => 'Tap Employee ID Card', 'badge' => 'Cashless Tap', 'desc' => 'Select your meal counter and tap your RFID ID card at the canteen reader.', 'preview_title' => 'Tap RFID Card', 'preview_status' => 'Meal Logged'],
                ['step' => 4, 'title' => 'Enjoy at Designated Seating', 'badge' => '350 Seats', 'desc' => 'Keep walkways clear and avoid saving empty seats during peak lunch hours.', 'preview_title' => 'Dining Zone', 'preview_status' => 'Comfort AC'],
                ['step' => 5, 'title' => 'Sort Waste & Return Tray', 'badge' => '5S Canteen', 'desc' => 'Separate organic leftovers, plastics, and return your tray cleanly to the rack.', 'preview_title' => 'Tray Station', 'preview_status' => 'Sorted Clean'],
            ],
            'workspace' => [
                ['step' => 1, 'title' => 'Locate Your Assigned Zone', 'badge' => 'Desk & Locker', 'desc' => 'Check your floor and wing code on your QR Desk Tent Card or Office Map.', 'preview_title' => 'Zone Finder', 'preview_status' => 'Floor 2 Wing'],
                ['step' => 2, 'title' => 'Set Up Ergonomic Station', 'badge' => 'Dual Monitor', 'desc' => 'Plug into the desk USB-C / power hub and adjust chair height comfortably.', 'preview_title' => 'Workstation', 'preview_status' => 'Power Ready'],
                ['step' => 3, 'title' => 'Store Valuables in Locker', 'badge' => 'RFID Locker', 'desc' => 'Keep bags and personal items inside your RFID locker to keep walkways clear.', 'preview_title' => 'Locker Access', 'preview_status' => 'Secured'],
                ['step' => 4, 'title' => 'Use Phone Booths for Calls', 'badge' => 'Focus Etiquette', 'desc' => 'Step into nearby phone booths or collaboration pods for long video meetings.', 'preview_title' => 'Phone Booth', 'preview_status' => 'Quiet Zone'],
                ['step' => 5, 'title' => 'Clean Desk Before Leaving', 'badge' => 'Win+L & 5S', 'desc' => 'Lock your screen, put away confidential files, and leave the desk neat.', 'preview_title' => 'Clean Desk', 'preview_status' => '5S Verified'],
            ],
            'wellness' => [
                ['step' => 1, 'title' => 'Verify Facility Etiquette', 'badge' => 'Signage Check', 'desc' => 'Follow entry signs (remove shoes for Musholla or check access for Nursing Room).', 'preview_title' => 'Access Sign', 'preview_status' => 'Open 24h / Shift'],
                ['step' => 2, 'title' => 'Use Clean Amenities', 'badge' => 'Sanitized', 'desc' => 'Use dedicated ablution taps, storage fridge, or resting seats properly.', 'preview_title' => 'Facility Ready', 'preview_status' => 'Hygienic'],
                ['step' => 3, 'title' => 'Maintain Quietness', 'badge' => 'Silent Zone', 'desc' => 'Keep your phone on silent and speak softly so colleagues can rest or pray comfortably.', 'preview_title' => 'Quiet Policy', 'preview_status' => 'Peaceful'],
                ['step' => 4, 'title' => 'Label Stored Items (Laktasi)', 'badge' => 'Name & Time', 'desc' => 'If using the chiller or storage area, tag items clearly with your name and date.', 'preview_title' => 'Storage Tag', 'preview_status' => 'Labeled'],
                ['step' => 5, 'title' => 'Leave Neat for Next Colleague', 'badge' => '5S Shared Care', 'desc' => 'Tidy footwear/equipment and notify GA if supplies need refilling.', 'preview_title' => 'Completed', 'preview_status' => 'Ready Next'],
            ],
            'safety' => [
                ['step' => 1, 'title' => 'Report Condition Immediately', 'badge' => 'Supervisor / HSE', 'desc' => 'Inform your supervisor or nearest colleague before heading to the clinic.', 'preview_title' => 'First Report', 'preview_status' => 'HSE Alert'],
                ['step' => 2, 'title' => 'Walk via Green Pedestrian Lane', 'badge' => 'Safe Route', 'desc' => 'Follow the green walkway on Floor 1/Plant to Clinic & First Aid room.', 'preview_title' => 'Green Path', 'preview_status' => 'Safest Path'],
                ['step' => 3, 'title' => 'Check In with Duty Paramedic', 'badge' => '24/7 Medical', 'desc' => 'Show your employee ID badge at the clinic desk for triage and vital check.', 'preview_title' => 'Medical Triage', 'preview_status' => 'Nurse On Duty'],
                ['step' => 4, 'title' => 'Receive Treatment / Rest', 'badge' => 'First Aid / AED', 'desc' => 'Rest on observation beds or receive emergency referral via standby ambulance.', 'preview_title' => 'Care Room', 'preview_status' => 'Stabilized'],
                ['step' => 5, 'title' => 'Log Return-to-Work / HSE Form', 'badge' => 'Zero Accident', 'desc' => 'Ensure medical leave or incident notes are logged for safety prevention.', 'preview_title' => 'Safety Log', 'preview_status' => 'Recorded'],
            ],
            default => [ // 'service' (Lobby, Visitor, Reception, Auditorium, Parking)
                ['step' => 1, 'title' => 'Pre-Register or Arrive at Desk', 'badge' => 'Digital Kiosk', 'desc' => 'Check in at the Virtual Reception tablet or employee RFID turnstile gate.', 'preview_title' => 'Check-In Desk', 'preview_status' => 'Verify ID'],
                ['step' => 2, 'title' => 'Confirm Host / Schedule', 'badge' => 'Host Notified', 'desc' => 'The system notifies your PIC/host automatically or displays directional info.', 'preview_title' => 'Host Alert', 'preview_status' => 'Approved'],
                ['step' => 3, 'title' => 'Wear Badge / Follow Parking Rule', 'badge' => 'Safety Policy', 'desc' => 'Wear Visitor Pass visibly inside buildings or follow Reverse Parking outdoors.', 'preview_title' => 'Access Pass', 'preview_status' => 'Active Pass'],
                ['step' => 4, 'title' => 'Use Lounge / Guided Facilities', 'badge' => 'Guest Wi-Fi', 'desc' => 'Connect to Guest Wi-Fi or wait at Lobby Lounge until escorted by your host.', 'preview_title' => 'Lounge & Wi-Fi', 'preview_status' => 'Connected'],
                ['step' => 5, 'title' => 'Check Out & Return Pass', 'badge' => 'Exit Scan', 'desc' => 'Return Visitor Pass or scan out via gate reader when departing complex.', 'preview_title' => 'Check-Out', 'preview_status' => 'Completed'],
            ],
        };
    }

    /**
     * Multi-image gallery helper for Slide 10 facility slider (1/4 counter).
     */
    public static function facilityGallery(Facility $facility): array
    {
        if (!empty($facility->gallery_images) && is_array($facility->gallery_images)) {
            return $facility->gallery_images;
        }

        $primary = $facility->image_path ?: '/images/facilities-office.jpg';
        $fallbacks = match ($facility->category) {
            'meeting' => ['/images/meeting-room.jpg', '/images/facilities-office.jpg', '/images/hero-office.jpg', '/images/floorplan-preview.jpg'],
            'dining' => ['/images/management-office.jpg', '/images/hero-office.jpg', '/images/facilities-office.jpg'],
            'service' => ['/images/hero-office.jpg', '/images/plant-exterior.jpg', '/images/floorplan-preview.jpg'],
            default => ['/images/facilities-office.jpg', '/images/hero-office.jpg', '/images/meeting-room.jpg'],
        };

        $gallery = array_values(array_unique(array_merge([$primary], $fallbacks)));
        return array_slice($gallery, 0, 4);
    }

    /**
     * Architectural 2D Floor Map room blocks & corridor graph for Slides 4 & 7.
     * Coordinates are percentages on a 1000x560 architectural canvas.
     */
    public static function architecturalBlueprints(): array
    {
        return [
            'Lantai 1' => [
                'code' => '1F',
                'building' => 'Main Office',
                'title' => 'Main Office – Floor 1',
                'subtitle' => 'Lobby, Canteen, Clinic, Musholla & Visitor Reception Area',
                'start' => ['x' => 23, 'y' => 84, 'label' => 'Main Entrance & Security Gate'],
                'corridor_y' => 52,
                'corridor_x' => 50,
                'rooms' => [
                    ['code' => 'MO-101', 'name' => 'Lobi Utama & Resepsionis', 'label' => "MAIN LOBBY\n& RECEPTION", 'group' => 'Office Area', 'color' => 'bg-sky-200 border-sky-400 text-sky-900', 'x' => 8, 'y' => 14, 'w' => 24, 'h' => 30, 'cx' => 20, 'cy' => 29, 'capacity' => '50 Tamu', 'facilities' => 'Visitor Kiosk, Virtual Reception, Guest Wi-Fi', 'usage' => 'Registrasi tamu & penerimaan kunjungan bisnis', 'book' => 'Online Visitor Portal / Resepsionis', 'image' => '/images/hero-office.jpg'],
                    ['code' => 'MO-106', 'name' => 'Auditorium & Training', 'label' => "AUDITORIUM\nHALL", 'group' => 'Meeting Room', 'color' => 'bg-pink-200 border-pink-400 text-pink-900', 'x' => 34, 'y' => 14, 'w' => 28, 'h' => 30, 'cx' => 48, 'cy' => 29, 'capacity' => '120 Orang', 'facilities' => 'LED Screen, Wireless Mic, Audio System', 'usage' => 'Townhall, training, dan sosialisasi karyawan', 'book' => 'Via SSO Portal (General Affairs)', 'image' => '/images/meeting-room.jpg'],
                    ['code' => 'MO-102', 'name' => 'Kantin Utama & Cafeteria', 'label' => "KANTIN UTAMA\n(350 KURSI)", 'group' => 'Pantry / Lounge', 'color' => 'bg-amber-200 border-amber-400 text-amber-900', 'x' => 64, 'y' => 14, 'w' => 28, 'h' => 32, 'cx' => 78, 'cy' => 30, 'capacity' => '350 Orang', 'facilities' => 'Tap ID Cashless, Dispenser, Hand Wash Station', 'usage' => 'Makan siang shift & area istirahat', 'book' => 'Akses Tap Kartu Pegawai (11:00 - 14:00)', 'image' => '/images/management-office.jpg'],
                    ['code' => 'MO-105', 'name' => 'Titik Kumpul Evakuasi', 'label' => "ASSEMBLY\nPOINT 1", 'group' => 'Emergency Exit', 'color' => 'bg-emerald-200 border-emerald-500 text-emerald-900', 'x' => 8, 'y' => 60, 'w' => 22, 'h' => 26, 'cx' => 19, 'cy' => 73, 'capacity' => '500 Orang', 'facilities' => 'Emergency Sign, Megaphone, First Aid Kit', 'usage' => 'Titik berkumpul resmi saat alarm darurat', 'book' => 'Akses Terbuka Darurat 24/7', 'image' => '/images/plant-exterior.jpg'],
                    ['code' => 'MO-104', 'name' => 'Musholla Al-Ikhlas', 'label' => "MUSHOLLA\nAL-IKHLAS", 'group' => 'Pantry / Lounge', 'color' => 'bg-purple-200 border-purple-400 text-purple-900', 'x' => 34, 'y' => 60, 'w' => 24, 'h' => 26, 'cx' => 46, 'cy' => 73, 'capacity' => '120 Jamaah', 'facilities' => 'Tempat Wudhu Modern, Sajadah, Full AC', 'usage' => 'Area ibadah karyawan pria & wanita', 'book' => 'Buka 24 Jam (Lepas Alas Kaki)', 'image' => '/images/meeting-room.jpg'],
                    ['code' => 'MO-103', 'name' => 'Klinik Medis & First Aid', 'label' => "KLINIK MEDIS\n& FIRST AID", 'group' => 'Support Room', 'color' => 'bg-rose-200 border-rose-400 text-rose-900', 'x' => 61, 'y' => 60, 'w' => 19, 'h' => 26, 'cx' => 70, 'cy' => 73, 'capacity' => '4 Bed Pasien', 'facilities' => 'Dokter/Paramedis Jaga, AED, Ambulans 24/7', 'usage' => 'Layanan medis P3K & konsultasi kesehatan', 'book' => 'Walk-in / Ext. 119 Darurat', 'image' => '/images/facilities-office.jpg'],
                    ['code' => 'MO-107', 'name' => 'Restroom Lt. 1', 'label' => "RESTROOM\n1F", 'group' => 'Restroom', 'color' => 'bg-cyan-100 border-cyan-400 text-cyan-900', 'x' => 82, 'y' => 60, 'w' => 10, 'h' => 26, 'cx' => 87, 'cy' => 73, 'capacity' => 'Pria / Wanita / Difabel', 'facilities' => 'Wastafel Sensor, Pengering Tangan', 'usage' => 'Fasilitas sanitasi lantai 1', 'book' => 'Akses Umum', 'image' => '/images/hero-office.jpg'],
                ],
                'icons' => [
                    ['type' => 'exit', 'x' => 7, 'y' => 52, 'label' => 'West Emergency Exit'],
                    ['type' => 'exit', 'x' => 93, 'y' => 52, 'label' => 'East Plant Link Exit'],
                    ['type' => 'apar', 'x' => 32, 'y' => 48, 'label' => 'APAR 1A'],
                    ['type' => 'apar', 'x' => 62, 'y' => 48, 'label' => 'APAR 1B'],
                    ['type' => 'stairs', 'x' => 59, 'y' => 50, 'label' => 'Main Staircase to 2F'],
                    ['type' => 'elevator', 'x' => 29, 'y' => 47, 'label' => 'Passenger Elevator'],
                ],
            ],
            'Lantai 2' => [
                'code' => '2F',
                'building' => 'Main Office',
                'title' => 'Main Office – Floor 2',
                'subtitle' => 'Tap the area to see details, photos, and directions.',
                'start' => ['x' => 44, 'y' => 92, 'label' => 'Main Entrance 2F'],
                'corridor_y' => 31,
                'corridor_x' => 31,
                'rooms' => [
                    ['code' => 'EXEC-01', 'name' => 'R. Tamu (Direksi)', 'label' => "R. TAMU\n(DIREKSI)", 'icon' => '👥', 'group' => 'Executive Room', 'color' => 'bg-[#ffcdd2] border-[#e57373] text-[#7f1d1d]', 'x' => 5, 'y' => 6, 'w' => 13, 'h' => 22, 'cx' => 11.5, 'cy' => 17, 'capacity' => '6 - 8 people', 'facilities' => 'VIP Lounge, Tea/Coffee Service, 4K Display', 'usage' => 'Executive guest reception & board hospitality', 'book' => 'Via Executive Secretary', 'image' => '/images/meeting-room.jpg'],
                    ['code' => 'EXEC-02', 'name' => 'Presidir Office', 'label' => "PRESIDIR", 'icon' => '👤', 'group' => 'Executive Room', 'color' => 'bg-[#ffe0b2] border-[#ffb74d] text-[#7c2d12]', 'x' => 18.5, 'y' => 6, 'w' => 12.5, 'h' => 22, 'cx' => 24.5, 'cy' => 17, 'capacity' => 'Executive Suite', 'facilities' => 'Private Board Table, Video Conference, Secure Line', 'usage' => 'President Director Private Office', 'book' => 'Restricted Access (Secretary)', 'image' => '/images/hero-office.jpg'],
                    ['code' => 'EXEC-03', 'name' => 'Vice President Office', 'label' => "VICE\nPRESIDENT", 'icon' => '👤', 'group' => 'Executive Room', 'color' => 'bg-[#fff9c4] border-[#ffd54f] text-[#713f12]', 'x' => 31.5, 'y' => 6, 'w' => 13, 'h' => 22, 'cx' => 38, 'cy' => 17, 'capacity' => 'Executive Suite', 'facilities' => 'Executive Desk, Discussion Table, VC Display', 'usage' => 'Vice President Private Office', 'book' => 'Restricted Access (Secretary)', 'image' => '/images/hero-office.jpg'],
                    ['code' => 'MO-205', 'name' => 'Private Meeting Room', 'label' => "PRIVATE\nMEETING ROOM", 'icon' => '👥', 'group' => 'Meeting Room', 'color' => 'bg-[#c8e6c9] border-[#66bb6a] text-[#14532d]', 'x' => 45, 'y' => 6, 'w' => 13, 'h' => 22, 'cx' => 51.5, 'cy' => 17, 'capacity' => '8 - 12 people', 'facilities' => '4K Smart Display, Camera (VC), Soundproof Glass', 'usage' => 'Confidential management & HR meetings', 'book' => 'Via Meeting Room System (Outlook / Web Portal)', 'image' => '/images/meeting-room.jpg', 'facility_slug' => 'ruang-rapat-sakura'],
                    ['code' => 'EXEC-04', 'name' => 'Direktur 1 Office', 'label' => "DIREKTUR 1", 'icon' => '👤', 'group' => 'Executive Room', 'color' => 'bg-[#bbdefb] border-[#64b5f6] text-[#1e3a8a]', 'x' => 58.5, 'y' => 6, 'w' => 12.5, 'h' => 22, 'cx' => 64.5, 'cy' => 17, 'capacity' => 'Director Suite', 'facilities' => 'Executive Desk, Private Meeting Corner', 'usage' => 'Director 1 Private Office', 'book' => 'Via Executive Secretary', 'image' => '/images/facilities-office.jpg'],
                    ['code' => 'EXEC-05', 'name' => 'Direktur 2 Office', 'label' => "DIREKTUR 2", 'icon' => '👤', 'group' => 'Executive Room', 'color' => 'bg-[#bbdefb] border-[#64b5f6] text-[#1e3a8a]', 'x' => 71.5, 'y' => 6, 'w' => 12.5, 'h' => 22, 'cx' => 77.5, 'cy' => 17, 'capacity' => 'Director Suite', 'facilities' => 'Executive Desk, Private Meeting Corner', 'usage' => 'Director 2 Private Office', 'book' => 'Via Executive Secretary', 'image' => '/images/facilities-office.jpg'],
                    ['code' => 'MO-206', 'name' => 'R. Perpus (Library)', 'label' => "R. PERPUS", 'icon' => '📖', 'group' => 'Support Room', 'color' => 'bg-[#e1bee7] border-[#ba68c8] text-[#4a148c]', 'x' => 84.5, 'y' => 6, 'w' => 11, 'h' => 22, 'cx' => 90, 'cy' => 17, 'capacity' => '12 - 15 people', 'facilities' => 'Quiet Reading Desk, Technical Archives, Printer', 'usage' => 'Engineering standards library & quiet study room', 'book' => 'Open Employee Access', 'image' => '/images/facilities-office.jpg'],
                    ['code' => 'MR-04', 'name' => 'Meeting Room 4', 'label' => "MEETING 4", 'icon' => '👥', 'group' => 'Meeting Room', 'color' => 'bg-[#ffcdd2] border-[#e57373] text-[#881337]', 'x' => 5, 'y' => 33, 'w' => 13, 'h' => 19, 'cx' => 11.5, 'cy' => 42.5, 'capacity' => '6 - 8 people', 'facilities' => 'Display, Camera, Microphone, Whiteboard', 'usage' => 'Cross-department team discussions', 'book' => 'Via Meeting Room System (Outlook / Web Portal)', 'image' => '/images/meeting-room.jpg', 'facility_slug' => 'meeting-room-5'],
                    ['code' => 'MR-05', 'name' => 'Meeting Room 5', 'label' => "MEETING 5", 'icon' => '👥', 'group' => 'Meeting Room', 'color' => 'bg-[#f8bbd0] border-[#ec407a] text-[#831843]', 'x' => 5, 'y' => 53, 'w' => 13, 'h' => 19, 'cx' => 11.5, 'cy' => 62.5, 'capacity' => '8–10 people', 'facilities' => 'Display, Camera, Microphone, Video Conference', 'usage' => 'For internal meeting & video conference', 'book' => 'Via Meeting Room System (Outlook / Web Portal)', 'image' => '/images/meeting-room.jpg', 'facility_slug' => 'meeting-room-5'],
                    ['code' => 'MO-202', 'name' => 'Manager to Staff Area', 'label' => "MANAGER TO STAFF\nAREA", 'icon' => '💼', 'group' => 'Office Area', 'color' => 'bg-white/95 border-slate-300 text-[#0f2e54]', 'x' => 35, 'y' => 50, 'w' => 20, 'h' => 10, 'cx' => 45, 'cy' => 55, 'capacity' => '180 Workstations', 'facilities' => 'Dual Monitor Ready, USB-C Hubs, Ergonomic Seating, Lockers', 'usage' => 'Open collaborative workspace for Manager to Staff', 'book' => 'Assigned Desk (See QR Tent Card)', 'image' => '/images/facilities-office.jpg', 'facility_slug' => 'open-workspace-collaboration'],
                    ['code' => 'MO-204', 'name' => 'Pantry Area', 'label' => "PANTRY\nAREA", 'icon' => '☕', 'group' => 'Pantry / Lounge', 'color' => 'bg-white/95 border-amber-300 text-slate-800', 'x' => 58, 'y' => 58, 'w' => 9.5, 'h' => 24, 'cx' => 62.5, 'cy' => 70, 'capacity' => '20 - 24 people', 'facilities' => 'Coffee Machine, Water Dispenser, Microwave, Lounge Chairs', 'usage' => 'Employee refreshment & informal break area', 'book' => 'Open Access (Follow 5S Rules)', 'image' => '/images/management-office.jpg'],
                    ['code' => 'REST-2F', 'name' => 'Restroom 2F', 'label' => "🚹 🚺", 'icon' => '🚻', 'group' => 'Restroom', 'color' => 'bg-[#dbeafe] border-[#60a5fa] text-[#1e3a8a]', 'x' => 74, 'y' => 34, 'w' => 10, 'h' => 22, 'cx' => 79, 'cy' => 45, 'capacity' => 'Men & Women', 'facilities' => 'Sensor Washbasin, Hand Dryer, Sanitizer', 'usage' => '2nd Floor employee & visitor restrooms', 'book' => 'Open Access', 'image' => '/images/hero-office.jpg'],
                    ['code' => 'SUP-01', 'name' => 'R. Server', 'label' => "R. SERVER", 'icon' => '🖧', 'group' => 'Support Room', 'color' => 'bg-[#b2ebf2] border-[#26c6da] text-[#083344]', 'x' => 84.5, 'y' => 45, 'w' => 11, 'h' => 21, 'cx' => 90, 'cy' => 55.5, 'capacity' => 'IT Authorized Only', 'facilities' => 'Server Racks, Precision Cooling, Fire Suppression', 'usage' => 'Core network & server room (IT Infrastructure)', 'book' => 'Biometric Access (IT Department)', 'image' => '/images/facilities-office.jpg'],
                    ['code' => 'SUP-02', 'name' => 'R. UPS', 'label' => "R. UPS", 'icon' => '🔋', 'group' => 'Support Room', 'color' => 'bg-[#bfdbfe] border-[#3b82f6] text-[#1e3a8a]', 'x' => 88, 'y' => 67, 'w' => 7.5, 'h' => 21, 'cx' => 91.5, 'cy' => 77.5, 'capacity' => 'GA / Electrical Only', 'facilities' => 'Uninterruptible Power Supply, Battery Bank', 'usage' => 'Emergency backup power distribution', 'book' => 'Authorized Technicians Only', 'image' => '/images/plant-exterior.jpg'],
                ],
                'icons' => [
                    ['type' => 'apar', 'x' => 19, 'y' => 30, 'label' => 'Fire Extinguisher (APAR 2A)'],
                    ['type' => 'apar', 'x' => 31, 'y' => 30, 'label' => 'Fire Extinguisher (APAR 2B)'],
                    ['type' => 'apar', 'x' => 44, 'y' => 30, 'label' => 'Fire Extinguisher (APAR 2C)'],
                    ['type' => 'apar', 'x' => 19, 'y' => 72, 'label' => 'Fire Extinguisher (APAR 2D)'],
                    ['type' => 'apar', 'x' => 36, 'y' => 89, 'label' => 'Fire Extinguisher (APAR 2E)'],
                    ['type' => 'apar', 'x' => 72, 'y' => 89, 'label' => 'Fire Extinguisher (APAR 2F)'],
                    ['type' => 'exit', 'x' => 19, 'y' => 42, 'label' => 'Emergency Exit Route'],
                    ['type' => 'exit', 'x' => 6, 'y' => 74, 'label' => 'West Emergency Staircase'],
                    ['type' => 'exit', 'x' => 9, 'y' => 89, 'label' => 'South-West Emergency Exit'],
                    ['type' => 'exit', 'x' => 75, 'y' => 89, 'label' => 'South-East Emergency Exit'],
                ],
            ],
            'Ground Floor' => [
                'code' => '3F / Plant',
                'building' => 'Plant 1 & Plant 2',
                'title' => 'Plant Complex & Main Yard',
                'subtitle' => 'Manufacturing lines, logistics hub, EV charging & green pedestrian paths',
                'start' => ['x' => 16, 'y' => 86, 'label' => 'Main Office Connector Gate'],
                'corridor_y' => 82,
                'corridor_x' => 50,
                'rooms' => [
                    ['code' => 'PL-01', 'name' => 'Plant 1: Machining & Foundry', 'label' => "PLANT 1:\nMACHINING & FOUNDRY", 'group' => 'Office Area', 'color' => 'bg-slate-200 border-slate-400 text-slate-900', 'x' => 8, 'y' => 14, 'w' => 38, 'h' => 56, 'cx' => 27, 'cy' => 42, 'capacity' => 'Area Produksi', 'facilities' => 'Automated CNC, Casting Line, Green Walkway', 'usage' => 'Produksi rotor & kaliper rem (Wajib APD Penuh)', 'book' => 'Supervisor Izin Masuk (Ext. 301)', 'image' => '/images/plant-exterior.jpg'],
                    ['code' => 'PL-02', 'name' => 'Plant 2: Automated Assembly', 'label' => "PLANT 2:\nAUTOMATED ASSEMBLY", 'group' => 'Office Area', 'color' => 'bg-indigo-200 border-indigo-400 text-indigo-900', 'x' => 50, 'y' => 14, 'w' => 42, 'h' => 38, 'cx' => 71, 'cy' => 33, 'capacity' => 'Clean Assembly', 'facilities' => 'Robotic Line, Leak Test, Quality Inspection', 'usage' => 'Perakitan akhir komponen rem OEM', 'book' => 'Supervisor Assembly (Ext. 302)', 'image' => '/images/hero-office.jpg'],
                    ['code' => 'PL-03', 'name' => 'Logistics & Loading Dock', 'label' => "LOGISTICS HUB\n& LOADING DOCK", 'group' => 'Support Room', 'color' => 'bg-amber-200 border-amber-400 text-amber-900', 'x' => 50, 'y' => 56, 'w' => 42, 'h' => 20, 'cx' => 71, 'cy' => 66, 'capacity' => '6 Dock Bays', 'facilities' => 'Dock Leveler, Forklift Crossing Lane', 'usage' => 'Inbound material & dispatch barang jadi', 'book' => 'Logistics Desk (Ext. 350)', 'image' => '/images/plant-exterior.jpg'],
                ],
                'icons' => [
                    ['type' => 'exit', 'x' => 6, 'y' => 84, 'label' => 'West Plant Assembly Exit'],
                    ['type' => 'exit', 'x' => 93, 'y' => 84, 'label' => 'East Yard Assembly Exit'],
                    ['type' => 'apar', 'x' => 48, 'y' => 50, 'label' => 'Hydrant & APAR P1/P2'],
                    ['type' => 'restroom', 'x' => 48, 'y' => 20, 'label' => 'Plant Locker & Restroom'],
                ],
            ],
        ];
    }
}
