<?php

namespace Database\Seeders;

use App\Models\DosAndDont;
use App\Models\EmergencyContact;
use App\Models\Facility;
use App\Models\ManagementMessage;
use App\Models\OfficeZone;
use Illuminate\Database\Seeder;

class DigitalOfficeGuideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Management Message
        ManagementMessage::truncate();
        ManagementMessage::create([
            'title' => 'A Message from Management',
            'sender_name' => 'Board of Management Akebono Brake Astra Indonesia',
            'sender_role' => 'President Director & Executive Committee',
            'summary' => 'As we begin a new chapter at our Karawang office, let us build a safer, more collaborative, and future-ready workplace — together.',
            'content' => "Selamat datang di Fasilitas Kantor & Pabrik Baru Akebono Karawang.\n\nPerjalanan baru ini menandai komitmen kami untuk menghadirkan lingkungan kerja berkelas dunia yang mengintegrasikan efisiensi manufaktur modern dengan kenyamanan dan kesejahteraan seluruh karyawan. Fasilitas Karawang dirancang dengan standar keselamatan tertinggi (Zero Accident Mindset), arsitektur ramah lingkungan, serta teknologi kolaboratif terkini.\n\nDi tempat baru ini, mari kita bersama-sama memperkuat budaya 5S (Seiri, Seiton, Seiso, Seiketsu, Shitsuke), menjunjung tinggi integritas, dan saling menghargai ruang kerja bersama. Ruang-ruang kerja terbuka, ruang rapat cerdas, dan fasilitas penunjang yang komprehensif ini didedikasikan untuk mendukung produktivitas dan inovasi kita bersama.\n\nMari kita jadikan setiap sudut kantor ini tempat di mana ide-ide terbaik lahir dan masa depan industri otomotif dibangun dengan rasa bangga.",
            'quote' => 'Moving Together. Working Better. Growing Stronger.',
            'image_path' => '/images/management-office.jpg',
            'is_active' => true,
        ]);

        // 2. Facilities
        Facility::truncate();
        $facilities = [
            [
                'name' => 'Lobi Utama & Resepsionis',
                'slug' => 'lobi-utama-dan-resepsionis',
                'category' => 'service',
                'floor' => 'Lantai 1',
                'location_detail' => 'Gedung Utama Lt. 1, Pintu Masuk Barat',
                'capacity' => '50 Tamu',
                'operating_hours' => '07:00 - 17:30 WIB',
                'description' => 'Area penyambutan utama bagi tamu, mitra bisnis, dan karyawan dengan meja registrasi digital, visitor pass, dan ruang tunggu representatif.',
                'guidelines' => 'Setiap pengunjung wajib mendaftarkan identitas di sistem resepsionis dan mengenakan ID badge pengunjung selama berada di area kantor.',
                'amenities' => ['Visitor Self Check-in', 'Lounge Sofa', 'Wi-Fi Tamu', 'Display Informasi Digital', 'Sanitizer Station'],
                'icon' => 'building',
                'image_path' => '/images/hero-office.jpg',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Ruang Rapat Executive "Sakura"',
                'slug' => 'ruang-rapat-sakura',
                'category' => 'meeting',
                'floor' => 'Lantai 2',
                'location_detail' => 'Gedung Utama Lt. 2, Koridor Eksekutif',
                'capacity' => '24 Orang',
                'operating_hours' => '07:30 - 18:00 WIB',
                'description' => 'Boardroom modern berkapasitas besar dengan meja kayu solid ergonomis, sistem konferensi video 4K, dan mikrofon konferensi terintegrasi.',
                'guidelines' => 'Pemesanan wajib melalui sistem Outlook/Google Calendar minimal 1 hari sebelumnya. Harap matikan perangkat presentasi setelah selesai.',
                'amenities' => ['Smart Screen 85"', 'Cisco Webex / Teams Room', 'High-Speed Wi-Fi', 'Microphone Array', 'Mini Pantry Corner'],
                'icon' => 'users',
                'image_path' => '/images/meeting-room.jpg',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Open Workspace & Collaboration Pods',
                'slug' => 'open-workspace-collaboration',
                'category' => 'workspace',
                'floor' => 'Lantai 2',
                'location_detail' => 'Gedung Utama Lt. 2, Sayap Timur & Barat',
                'capacity' => '180 Workstations',
                'operating_hours' => '24 Jam (Operasional Shift)',
                'description' => 'Ruang kerja terbuka dengan pencahayaan alami melimpah, meja modular ergonomis, colokan daya di setiap meja, dan area diskusi santai.',
                'guidelines' => 'Terapkan Clean Desk Policy. Seluruh dokumen rahasia wajib disimpan di laci berkunci saat jam kerja usai.',
                'amenities' => ['Dual Monitor Ready', 'Ergonomic Chair', 'Power Hub & USB-C', 'Private Phone Booths', 'Locker RFID'],
                'icon' => 'laptop',
                'image_path' => '/images/facilities-office.jpg',
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Kantin Utama & Cafeteria',
                'slug' => 'kantin-utama-cafeteria',
                'category' => 'dining',
                'floor' => 'Lantai 1',
                'location_detail' => 'Gedung Utama Lt. 1, Belakang Lobi Barat',
                'capacity' => '350 Orang',
                'operating_hours' => '11:00 - 14:00 (Makan Siang) & 17:00 - 19:30 (Shift Malam)',
                'description' => 'Cafeteria bersih ber-AC dengan menu harian seimbang berstandar gizi, area cuci tangan otomatis, dan sistem transaksi tap kartu pegawai.',
                'guidelines' => 'Kembalikan baki dan pisahkan alat makan serta sampah sesuai tempatnya (Organik, Anorganik, Residu).',
                'amenities' => ['Sistem Cashless Tap ID', 'Free Dispenser Air Minum', 'Hand Washing Station', 'Coffee Machine Corner', 'AC & Musik Relaksasi'],
                'icon' => 'coffee',
                'image_path' => '/images/management-office.jpg',
                'is_featured' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Klinik Kesehatan & First Aid',
                'slug' => 'klinik-kesehatan-first-aid',
                'category' => 'safety',
                'floor' => 'Lantai 1',
                'location_detail' => 'Gedung Utama Lt. 1, Samping Musholla',
                'capacity' => '4 Tempat Tidur Pasien',
                'operating_hours' => '24 Jam',
                'description' => 'Fasilitas medis darurat dengan perawat dan dokter jaga, tabung oksigen, AED (Automated External Defibrillator), dan obat-obatan standar P3K.',
                'guidelines' => 'Bagi karyawan yang merasa tidak enak badan atau mengalami insiden kerja, segera lapor ke atasan dan kunjungi klinik.',
                'amenities' => ['Dokter & Paramedis Jaga', 'Ambulans Siaga 24/7', 'AED Defibrillator', 'Obat Resep Terstandar', 'Timbangan & Pengukur Tensi Digital'],
                'icon' => 'activity',
                'image_path' => '/images/facilities-office.jpg',
                'is_featured' => false,
                'sort_order' => 5,
            ],
            [
                'name' => 'Musholla Al-Ikhlas & Ruang Wudhu',
                'slug' => 'musholla-al-ikhlas',
                'category' => 'wellness',
                'floor' => 'Lantai 1',
                'location_detail' => 'Gedung Utama Lt. 1, Koridor Selatan',
                'capacity' => '120 Jamaah',
                'operating_hours' => '24 Jam',
                'description' => 'Tempat ibadah yang tenang, sejuk, dan bersih dengan pemisahan area pria dan wanita, rak sandal tertata, dan mukena/sarung bersih.',
                'guidelines' => 'Lepas alas kaki sebelum batas suci dan letakkan di rak sepatu. Jaga keheningan dan ketertiban selama di musholla.',
                'amenities' => ['Tempat Wudhu Modern Pria & Wanita', 'Karpet Sajadah Tebal', 'Al-Quran & Lemari Tertata', 'Sound System Adzan', 'Full AC'],
                'icon' => 'heart',
                'image_path' => '/images/meeting-room.jpg',
                'is_featured' => false,
                'sort_order' => 6,
            ],
            [
                'name' => 'Ruang Laktasi (Nursing Room)',
                'slug' => 'ruang-laktasi-nursing-room',
                'category' => 'wellness',
                'floor' => 'Lantai 2',
                'location_detail' => 'Gedung Utama Lt. 2, Dekat Toilet Wanita',
                'capacity' => '3 Ruang Bilik Privat',
                'operating_hours' => '07:00 - 18:00 WIB',
                'description' => 'Ruang privat yang dirancang nyaman dan higienis bagi ibu menyusui untuk memerah ASI, dilengkapi kulkas khusus ASI dan sofa santai.',
                'guidelines' => 'Hanya diperuntukkan bagi karyawan wanita. Jaga kebersihan meja dan cuci tangan sebelum serta sesudah memerah.',
                'amenities' => ['Kulkas Khusus Penyimpanan ASI', 'Sofa Ergonomis dengan Tirai Penutup', 'Wastafel & Sabun Antiseptik', 'Stopkontak Listrik Pompa ASI', 'Pemanas Botol'],
                'icon' => 'smile',
                'image_path' => '/images/facilities-office.jpg',
                'is_featured' => false,
                'sort_order' => 7,
            ],
            [
                'name' => 'Area Parkir & Charging Station EV',
                'slug' => 'area-parkir-dan-ev-charging',
                'category' => 'service',
                'floor' => 'Outdoor',
                'location_detail' => 'Halaman Barat & Timur Gedung Utama',
                'capacity' => '200 Mobil & 600 Sepeda Motor',
                'operating_hours' => '24 Jam',
                'description' => 'Area parkir teratur dengan kanopi peneduh motor, jalur pejalan kaki beratap, dan 4 titik pengisian daya kendaraan listrik (EV Charging).',
                'guidelines' => 'Parkir mundur di setiap slot parkir roda empat (Reverse Parking Policy) demi kemudahan evakuasi darurat.',
                'amenities' => ['Reverse Parking Guidelines', 'Kanopi Motor Teduh', 'EV Fast Charging 22kW', 'CCTV 24 Jam', 'Penerangan Solar Panel LED'],
                'icon' => 'truck',
                'image_path' => '/images/plant-exterior.jpg',
                'is_featured' => false,
                'sort_order' => 8,
            ],
        ];

        foreach ($facilities as $facility) {
            Facility::create($facility);
        }

        // 3. Dos & Don'ts
        DosAndDont::truncate();
        $rules = [
            // HSE & Keselamatan
            [
                'category' => 'HSE & Keselamatan',
                'type' => 'do',
                'title' => 'Gunakan APD Lengkap di Area Pabrik & Bengkel',
                'description' => 'Kenakan safety shoes, safety glasses, rompi reflektif, dan helm pelindung yang telah distandarisasi saat memasuki zona workshop dan pabrik.',
                'tip_or_consequence' => 'Keselamatan adalah prioritas nomor satu. Pengabaian APD dapat berakibat teguran keselamatan dan sanksi kedisiplinan.',
                'icon' => 'shield-check',
                'sort_order' => 1,
            ],
            [
                'category' => 'HSE & Keselamatan',
                'type' => 'do',
                'title' => 'Gunakan Jalur Hijau (Green Walkway)',
                'description' => 'Selalu berjalan di jalur hijau bertanda pejalan kaki dan perhatikan lampu rambu penyeberangan jalur forklift.',
                'tip_or_consequence' => 'Mencegah potensi tabrakan dengan kendaraan logistik internal dan material handling.',
                'icon' => 'check-circle',
                'sort_order' => 2,
            ],
            [
                'category' => 'HSE & Keselamatan',
                'type' => 'dont',
                'title' => 'Dilarang Berjalan Sambil Menatap Layar HP',
                'description' => 'Hindari mengetik atau menonton di ponsel saat berjalan, menaiki tangga, atau melintasi persimpangan pabrik.',
                'tip_or_consequence' => 'Hilang fokus dapat mengakibatkan tersandung, jatuh dari tangga, atau tertabrak kendaraan operasional.',
                'icon' => 'alert-triangle',
                'sort_order' => 3,
            ],
            [
                'category' => 'HSE & Keselamatan',
                'type' => 'dont',
                'title' => 'Dilarang Merokok Sembarangan',
                'description' => 'Merokok dan vaping (rokok elektrik) sangat dilarang di dalam gedung kantor, toilet, gudang, dan area produksi.',
                'tip_or_consequence' => 'Gunakan designated smoking shelter di area luar ruangan yang telah ditentukan.',
                'icon' => 'x-circle',
                'sort_order' => 4,
            ],

            // Etiket Kerja & Lingkungan
            [
                'category' => 'Etiket Kerja & Lingkungan',
                'type' => 'do',
                'title' => 'Terapkan Clean Desk Policy & 5S Setiap Hari',
                'description' => 'Rapikan meja kerja, singkirkan sampah, dan amankan dokumen penting sebelum meninggalkan kantor di penghujung hari.',
                'tip_or_consequence' => 'Menciptakan lingkungan kerja yang nyaman, higienis, dan teratur untuk produktivitas esok hari.',
                'icon' => 'sparkles',
                'sort_order' => 5,
            ],
            [
                'category' => 'Etiket Kerja & Lingkungan',
                'type' => 'do',
                'title' => 'Gunakan Phone Booth untuk Panggilan Panjang',
                'description' => 'Manfaatkan private phone booth akustik jika Anda perlu melakukan panggilan video atau telepon intensif agar tidak mengganggu rekan di open space.',
                'tip_or_consequence' => 'Menjaga kenyamanan fokus kerja bersama di area open workspace.',
                'icon' => 'phone',
                'sort_order' => 6,
            ],
            [
                'category' => 'Etiket Kerja & Lingkungan',
                'type' => 'dont',
                'title' => 'Dilarang "Ghost Booking" Ruang Rapat',
                'description' => 'Jangan memesan ruang rapat jika Anda tidak menggunakannya. Jika rapat dibatalkan, segera batalkan pemesanan di kalender ruangan.',
                'tip_or_consequence' => 'Ruang rapat yang tidak digunakan selama 15 menit dari jadwal akan otomatis dibebaskan untuk tim lain.',
                'icon' => 'calendar-x',
                'sort_order' => 7,
            ],
            [
                'category' => 'Etiket Kerja & Lingkungan',
                'type' => 'dont',
                'title' => 'Dilarang Meninggalkan Sampah di Meja Rapat',
                'description' => 'Selalu bawa gelas, botol, dan catatan bekas setelah rapat selesai agar ruangan siap digunakan oleh tim berikutnya.',
                'tip_or_consequence' => 'Hormati rekan kerja lain yang akan menggunakan ruangan tersebut segera setelah Anda.',
                'icon' => 'trash-2',
                'sort_order' => 8,
            ],

            // Keamanan Informasi & TI
            [
                'category' => 'Keamanan Informasi & TI',
                'type' => 'do',
                'title' => 'Kunci Komputer Saat Meninggalkan Meja (Win + L)',
                'description' => 'Pastikan PC/Laptop terkunci setiap kali Anda beranjak dari workstation, meskipun hanya untuk mengambil minum.',
                'tip_or_consequence' => 'Mencegah akses data internal oleh pihak yang tidak berkepentingan dan menjaga kerahasiaan data perusahaan.',
                'icon' => 'lock',
                'sort_order' => 9,
            ],
            [
                'category' => 'Keamanan Informasi & TI',
                'type' => 'do',
                'title' => 'Selalu Kenakan ID Badge Karyawan',
                'description' => 'Kenakan name tag dan access card di posisi dada yang terlihat selama berada di dalam komplek Akebono Karawang.',
                'tip_or_consequence' => 'Memudahkan identifikasi personel dan menjaga keamanan akses perimeter gedung.',
                'icon' => 'id-card',
                'sort_order' => 10,
            ],
            [
                'category' => 'Keamanan Informasi & TI',
                'type' => 'dont',
                'title' => 'Dilarang Memotret & Merekam Tanpa Izin Resmi',
                'description' => 'Dilarang mengambil foto atau merekam video di area lini manufaktur, mesin perakitan, dan dokumen teknis.',
                'tip_or_consequence' => 'Melindungi hak kekayaan intelektual (IP) dan rahasia dagang teknologi pengereman Akebono.',
                'icon' => 'camera-off',
                'sort_order' => 11,
            ],
            [
                'category' => 'Keamanan Informasi & TI',
                'type' => 'dont',
                'title' => 'Dilarang Menghubungkan Device Pribadi ke Jaringan Kantor Tanpa Izin',
                'description' => 'Jangan mencolokkan router, access point, atau flash disk yang tidak terenkripsi ke jaringan LAN intranet.',
                'tip_or_consequence' => 'Gunakan jaringan Wi-Fi Akebono-Guest untuk perangkat ponsel pribadi.',
                'icon' => 'wifi-off',
                'sort_order' => 12,
            ],
        ];

        foreach ($rules as $rule) {
            DosAndDont::create($rule);
        }

        // 4. Office Zones / Map
        OfficeZone::truncate();
        $zones = [
            // Lantai 1 Gedung Utama
            [
                'building' => 'Gedung Utama (Main Office)',
                'floor' => 'Lantai 1',
                'code' => 'MO-101',
                'name' => 'Lobi Utama & Resepsionis Digital',
                'type' => 'workstation',
                'coord_x' => 20.0,
                'coord_y' => 30.0,
                'description' => 'Pintu masuk utama, meja resepsionis, registrasi tamu, dan ruang tunggu eksekutif.',
                'contact_person' => 'Front Desk (Ext. 101)',
                'sort_order' => 1,
            ],
            [
                'building' => 'Gedung Utama (Main Office)',
                'floor' => 'Lantai 1',
                'code' => 'MO-102',
                'name' => 'Kantin Utama & Cafeteria',
                'type' => 'canteen',
                'coord_x' => 70.0,
                'coord_y' => 30.0,
                'description' => 'Kantin berkapasitas 350 kursi dengan buffet makan siang dan area relaksasi.',
                'contact_person' => 'General Affairs (Ext. 104)',
                'sort_order' => 2,
            ],
            [
                'building' => 'Gedung Utama (Main Office)',
                'floor' => 'Lantai 1',
                'code' => 'MO-103',
                'name' => 'Klinik Medis & First Aid Room',
                'type' => 'clinic',
                'coord_x' => 45.0,
                'coord_y' => 45.0,
                'description' => 'Ruang periksa dokter, tempat tidur observasi darurat, dan obat-obatan P3K.',
                'contact_person' => 'Paramedis (Ext. 119)',
                'sort_order' => 3,
            ],
            [
                'building' => 'Gedung Utama (Main Office)',
                'floor' => 'Lantai 1',
                'code' => 'MO-104',
                'name' => 'Musholla Al-Ikhlas & Tempat Wudhu',
                'type' => 'musholla',
                'coord_x' => 45.0,
                'coord_y' => 70.0,
                'description' => 'Tempat ibadah shalat berjamaah berkapasitas 120 jamaah dengan tempat wudhu modern.',
                'contact_person' => 'DKM Akebono (Ext. 105)',
                'sort_order' => 4,
            ],
            [
                'building' => 'Gedung Utama (Main Office)',
                'floor' => 'Lantai 1',
                'code' => 'MO-105',
                'name' => 'Titik Kumpul Evakuasi (Assembly Point 1)',
                'type' => 'emergency',
                'coord_x' => 15.0,
                'coord_y' => 85.0,
                'description' => 'Area terbuka zona aman evakuasi kebakaran dan gempa di pelataran barat kantor.',
                'contact_person' => 'HSE Commander (Ext. 112)',
                'sort_order' => 5,
            ],

            // Lantai 2 Gedung Utama
            [
                'building' => 'Gedung Utama (Main Office)',
                'floor' => 'Lantai 2',
                'code' => 'MO-201',
                'name' => 'Ruang Rapat Executive "Sakura"',
                'type' => 'meeting',
                'coord_x' => 25.0,
                'coord_y' => 25.0,
                'description' => 'Boardroom VIP kapasitas 24 orang dilengkapi teknologi smart hybrid conference.',
                'contact_person' => 'Admin Secretary (Ext. 201)',
                'sort_order' => 6,
            ],
            [
                'building' => 'Gedung Utama (Main Office)',
                'floor' => 'Lantai 2',
                'code' => 'MO-202',
                'name' => 'Open Workspace Engineering & Design',
                'type' => 'workstation',
                'coord_x' => 65.0,
                'coord_y' => 35.0,
                'description' => 'Ruang kerja tim Engineering, Quality Assurance, dan Product Development.',
                'contact_person' => 'Dept. Head (Ext. 210)',
                'sort_order' => 7,
            ],
            [
                'building' => 'Gedung Utama (Main Office)',
                'floor' => 'Lantai 2',
                'code' => 'MO-203',
                'name' => 'Ruang Laktasi (Nursing Room)',
                'type' => 'restroom',
                'coord_x' => 30.0,
                'coord_y' => 65.0,
                'description' => 'Ruang tenang dan higienis khusus ibu menyusui dengan kulkas ASI.',
                'contact_person' => 'Clinic / GA (Ext. 119)',
                'sort_order' => 8,
            ],
            [
                'building' => 'Gedung Utama (Main Office)',
                'floor' => 'Lantai 2',
                'code' => 'MO-204',
                'name' => 'Collaboration Lounge & Coffee Corner',
                'type' => 'canteen',
                'coord_x' => 75.0,
                'coord_y' => 75.0,
                'description' => 'Area santai untuk diskusi kreatif, brainstorming tim, dan mini pantry.',
                'contact_person' => 'GA (Ext. 104)',
                'sort_order' => 9,
            ],

            // Plant & Fabrikasi
            [
                'building' => 'Plant Area (Pabrik)',
                'floor' => 'Ground Floor',
                'code' => 'PL-01',
                'name' => 'Plant 1: Machining & Foundry Center',
                'type' => 'workstation',
                'coord_x' => 35.0,
                'coord_y' => 40.0,
                'description' => 'Area pemrosesan casting dan machining komponen sistem rem kendaraan bermotor.',
                'contact_person' => 'Plant Supervisor (Ext. 301)',
                'sort_order' => 10,
            ],
            [
                'building' => 'Plant Area (Pabrik)',
                'floor' => 'Ground Floor',
                'code' => 'PL-02',
                'name' => 'Plant 2: Automated Brake Assembly Line',
                'type' => 'workstation',
                'coord_x' => 70.0,
                'coord_y' => 45.0,
                'description' => 'Lini perakitan otomatis kaliper dan kampas rem standar OEM otomotif.',
                'contact_person' => 'Assembly Head (Ext. 302)',
                'sort_order' => 11,
            ],
            [
                'building' => 'Plant Area (Pabrik)',
                'floor' => 'Ground Floor',
                'code' => 'PL-03',
                'name' => 'Logistics Hub & Loading Dock',
                'type' => 'workstation',
                'coord_x' => 85.0,
                'coord_y' => 80.0,
                'description' => 'Pusat distribusi material inbound dan pengiriman finished goods.',
                'contact_person' => 'Logistics Team (Ext. 350)',
                'sort_order' => 12,
            ],
        ];

        foreach ($zones as $zone) {
            OfficeZone::create($zone);
        }

        // 5. Emergency Contacts
        EmergencyContact::truncate();
        $contacts = [
            [
                'name' => 'Security Pos Utama (24 Jam)',
                'phone' => '(0267) 845-9001',
                'extension' => 'Ext. 100 / 101',
                'location' => 'Gate 1 Pos Barat',
                'operating_hours' => '24 Jam Nonstop',
                'is_hotline' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Klinik Medis & Emergency Response',
                'phone' => '(0267) 845-9002',
                'extension' => 'Ext. 119',
                'location' => 'Gedung Utama Lt. 1',
                'operating_hours' => '24 Jam Nonstop',
                'is_hotline' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'HSE Safety Officer On Duty',
                'phone' => '(0267) 845-9003',
                'extension' => 'Ext. 112',
                'location' => 'Safety Command Center',
                'operating_hours' => 'Setiap Hari Kerja & Jam Shift',
                'is_hotline' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Pemadam Kebakaran Internal (ERT)',
                'phone' => '(0267) 845-9004',
                'extension' => 'Ext. 113',
                'location' => 'Fire Station Komplek Karawang',
                'operating_hours' => '24 Jam Siaga',
                'is_hotline' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'IT Helpdesk & Cyber Security Support',
                'phone' => '(0267) 845-9005',
                'extension' => 'Ext. 200',
                'location' => 'Server Room Gedung Utama Lt. 2',
                'operating_hours' => '07:00 - 19:00 WIB',
                'is_hotline' => false,
                'sort_order' => 5,
            ],
            [
                'name' => 'General Affairs & Facility Management',
                'phone' => '(0267) 845-9006',
                'extension' => 'Ext. 104',
                'location' => 'GA Office Lt. 1',
                'operating_hours' => '07:30 - 17:00 WIB',
                'is_hotline' => false,
                'sort_order' => 6,
            ],
        ];

        foreach ($contacts as $contact) {
            EmergencyContact::create($contact);
        }
    }
}

