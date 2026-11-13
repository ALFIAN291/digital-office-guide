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
                'subtitle' => 'Tap a room or facility to see details and get directions.',
                'start' => ['x' => 46, 'y' => 86, 'label' => 'Main Staircase / Elevator 2F'],
                'corridor_y' => 33,
                'corridor_x' => 39,
                'rooms' => [
                    ['code' => 'EXEC-01', 'name' => 'R. Tamu (Direksi)', 'label' => "R. TAMU\n(DIREKSI)", 'group' => 'Executive Room', 'color' => 'bg-rose-200 border-rose-400 text-rose-900', 'x' => 11, 'y' => 8, 'w' => 12, 'h' => 20, 'cx' => 17, 'cy' => 18, 'capacity' => '6-8 people', 'facilities' => 'VIP Lounge, Tea/Coffee Service, 4K Display', 'usage' => 'Penerimaan tamu eksekutif direksi', 'book' => 'Melalui Sekretaris Direksi', 'image' => '/images/meeting-room.jpg'],
                    ['code' => 'EXEC-02', 'name' => 'Ruang Presdir', 'label' => "PRESDIR", 'group' => 'Executive Room', 'color' => 'bg-amber-200 border-amber-400 text-amber-900', 'x' => 24, 'y' => 8, 'w' => 9, 'h' => 20, 'cx' => 28, 'cy' => 18, 'capacity' => 'Executive Office', 'facilities' => 'Private Board Table, Secure Line', 'usage' => 'Area terbatas Kantor Presiden Direktur', 'book' => 'Akses Khusus (Restricted)', 'image' => '/images/hero-office.jpg'],
                    ['code' => 'EXEC-03', 'name' => 'Vice President Office', 'label' => "VICE\nPRESIDENT", 'group' => 'Executive Room', 'color' => 'bg-amber-200 border-amber-400 text-amber-900', 'x' => 34, 'y' => 8, 'w' => 9, 'h' => 20, 'cx' => 38, 'cy' => 18, 'capacity' => 'Executive Office', 'facilities' => 'Private Desk, Mini Discussion Table', 'usage' => 'Area terbatas Kantor Vice President', 'book' => 'Akses Khusus (Restricted)', 'image' => '/images/hero-office.jpg'],
                    ['code' => 'MO-205', 'name' => 'Private Meeting Room', 'label' => "PRIVATE\nMEETING ROOM", 'group' => 'Meeting Room', 'color' => 'bg-emerald-200 border-emerald-400 text-emerald-900', 'x' => 44, 'y' => 8, 'w' => 11, 'h' => 20, 'cx' => 49, 'cy' => 18, 'capacity' => '8-12 people', 'facilities' => 'Smart Display, Video Conference, Soundproof Glass', 'usage' => 'Rapat tertutup manajemen & HR', 'book' => 'Via SSO Portal (Booking System)', 'image' => '/images/meeting-room.jpg'],
                    ['code' => 'EXEC-04', 'name' => 'Direktur 1 & 2 Suites', 'label' => "DIREKTUR 1 &\nDIREKTUR 2", 'group' => 'Executive Room', 'color' => 'bg-sky-200 border-sky-400 text-sky-900', 'x' => 56, 'y' => 8, 'w' => 15, 'h' => 20, 'cx' => 63, 'cy' => 18, 'capacity' => 'Directors Wing', 'facilities' => 'Private Suites, Conf Table', 'usage' => 'Kantor Direksi Operasional & Keuangan', 'book' => 'Melalui Sekretaris Direksi', 'image' => '/images/facilities-office.jpg'],
                    ['code' => 'MO-206', 'name' => 'R. Perpus & Arsip', 'label' => "R. PERPUS", 'group' => 'Support Room', 'color' => 'bg-purple-200 border-purple-400 text-purple-900', 'x' => 72, 'y' => 8, 'w' => 11, 'h' => 20, 'cx' => 77, 'cy' => 18, 'capacity' => '15 Orang', 'facilities' => 'Quiet Reading Desk, Technical Manuals, Printer', 'usage' => 'Perpustakaan standar teknik & ruang baca sunyi', 'book' => 'Akses Bebas Karyawan', 'image' => '/images/facilities-office.jpg'],
                    ['code' => 'MR-04', 'name' => 'Meeting Room 4', 'label' => "MEETING 4", 'group' => 'Meeting Room', 'color' => 'bg-pink-200 border-pink-400 text-pink-900', 'x' => 8, 'y' => 34, 'w' => 13, 'h' => 18, 'cx' => 14, 'cy' => 43, 'capacity' => '6-8 people', 'facilities' => '4K TV Display, HDMI Wireless, Whiteboard', 'usage' => 'Diskusi tim lintas departemen', 'book' => 'Via SSO Portal / Room Tablet', 'image' => '/images/meeting-room.jpg'],
                    ['code' => 'MR-05', 'name' => 'Meeting Room 5', 'label' => "MEETING 5", 'group' => 'Meeting Room', 'color' => 'bg-pink-300 border-pink-500 text-pink-950', 'x' => 8, 'y' => 53, 'w' => 13, 'h' => 18, 'cx' => 14, 'cy' => 62, 'capacity' => '8-10 people', 'facilities' => 'Display, Camera, Microphone, Video Conference', 'usage' => 'For internal meeting & video conference', 'book' => 'Via Meeting Room System (SSO / Web Portal)', 'image' => '/images/meeting-room.jpg', 'facility_slug' => 'ruang-rapat-sakura'],
                    ['code' => 'MO-202', 'name' => 'Manager to Staff Area', 'label' => "MANAGER TO STAFF\nOPEN WORKSPACE", 'group' => 'Office Area', 'color' => 'bg-slate-100 border-slate-300 text-slate-800', 'x' => 24, 'y' => 36, 'w' => 33, 'h' => 38, 'cx' => 40, 'cy' => 55, 'capacity' => '180 Workstations', 'facilities' => 'Dual Monitor Ready, USB-C Hubs, Ergonomic Seating', 'usage' => 'Area kerja terbuka IT, Engineering, HR, Finance', 'book' => 'Assigned Desk (Lihat QR Desk Card)', 'image' => '/images/facilities-office.jpg'],
                    ['code' => 'MO-204', 'name' => 'Pantry Area & Lounge', 'label' => "PANTRY AREA\n& LOUNGE", 'group' => 'Pantry / Lounge', 'color' => 'bg-amber-100 border-amber-400 text-amber-900', 'x' => 59, 'y' => 36, 'w' => 13, 'h' => 38, 'cx' => 65, 'cy' => 55, 'capacity' => '24 Orang', 'facilities' => 'Coffee Machine, Microwave, Refrigerator, Sofa', 'usage' => 'Pantry bersama, seduh kopi & kolaborasi santai', 'book' => 'Akses Terbuka Karyawan (Terapkan 5S)', 'image' => '/images/management-office.jpg'],
                    ['code' => 'SUP-01', 'name' => 'R. Server & IT Support', 'label' => "R. SERVER", 'group' => 'Support Room', 'color' => 'bg-cyan-200 border-cyan-500 text-cyan-950', 'x' => 75, 'y' => 35, 'w' => 14, 'h' => 19, 'cx' => 82, 'cy' => 44, 'capacity' => 'Restricted IT', 'facilities' => 'Data Center Rack, Cooling, Fire Suppression', 'usage' => 'Pusat jaringan & server (Ext. 200 IT Helpdesk)', 'book' => 'Akses Biometrik Tim IT', 'image' => '/images/facilities-office.jpg'],
                    ['code' => 'SUP-02', 'name' => 'R. UPS & Panel Listrik', 'label' => "R. UPS", 'group' => 'Support Room', 'color' => 'bg-cyan-200 border-cyan-500 text-cyan-950', 'x' => 75, 'y' => 56, 'w' => 14, 'h' => 19, 'cx' => 82, 'cy' => 65, 'capacity' => 'Restricted GA', 'facilities' => 'Backup Battery Bank, BMS Sensor', 'usage' => 'Kelistrikan cadangan gedung utama', 'book' => 'Hanya Teknisi Berizin', 'image' => '/images/plant-exterior.jpg'],
                    ['code' => 'MR-01', 'name' => 'Meeting 1 & 2 (Sakura)', 'label' => "MEETING 1 & 2\n(SAKURA)", 'group' => 'Meeting Room', 'color' => 'bg-amber-200 border-amber-400 text-amber-900', 'x' => 8, 'y' => 77, 'w' => 26, 'h' => 16, 'cx' => 21, 'cy' => 85, 'capacity' => '24 Orang', 'facilities' => 'Smart Screen 85", Cisco Webex, Microphone Array', 'usage' => 'Rapat besar proyek & komite eksekutif', 'book' => 'Via SSO Portal', 'image' => '/images/meeting-room.jpg', 'facility_slug' => 'ruang-rapat-sakura'],
                    ['code' => 'MR-03', 'name' => 'Meeting 3 & VIP Room', 'label' => "MEETING 3 &\nVIP ROOM", 'group' => 'Meeting Room', 'color' => 'bg-amber-200 border-amber-400 text-amber-900', 'x' => 60, 'y' => 77, 'w' => 29, 'h' => 16, 'cx' => 74, 'cy' => 85, 'capacity' => '12-16 Orang', 'facilities' => 'VC System, Glass Board, Wireless Sharing', 'usage' => 'Meeting vendor, audit & kunjungan prinsipal', 'book' => 'Via SSO Portal / Sekretaris', 'image' => '/images/meeting-room.jpg'],
                ],
                'icons' => [
                    ['type' => 'exit', 'x' => 6, 'y' => 68, 'label' => 'Emergency Exit Stairs West'],
                    ['type' => 'exit', 'x' => 91, 'y' => 12, 'label' => 'Emergency Exit Stairs East'],
                    ['type' => 'apar', 'x' => 22, 'y' => 33, 'label' => 'APAR 2A'],
                    ['type' => 'apar', 'x' => 57, 'y' => 33, 'label' => 'APAR 2B'],
                    ['type' => 'restroom', 'x' => 72, 'y' => 33, 'label' => 'Restroom 2F (Men/Women)'],
                    ['type' => 'stairs', 'x' => 66, 'y' => 66, 'label' => 'Spiral / Main Stairs'],
                    ['type' => 'elevator', 'x' => 22, 'y' => 68, 'label' => 'Main Elevator'],
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
