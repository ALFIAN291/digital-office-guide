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
                'title' => 'Jelajahi Gedung',
                'subtitle' => 'Tata letak kantor, zona pabrik & panduan arah',
                'route' => 'guide.office-and-plant',
                'matches' => ['guide.office-and-plant', 'guide.map'],
                'color' => 'sky',
                'icon' => 'building',
            ],
            [
                'number' => '02',
                'key' => 'facilities',
                'title' => 'Panduan Fasilitas',
                'subtitle' => 'Ruang rapat, pemesanan SSO & cara pakai 5 langkah',
                'route' => 'guide.facilities',
                'matches' => ['guide.facilities', 'guide.facility.detail'],
                'color' => 'cyan',
                'icon' => 'grid',
            ],
            [
                'number' => '03',
                'key' => 'safety',
                'title' => 'Aturan & Keselamatan',
                'subtitle' => 'Etiket kerja, budaya 5R & standar APD',
                'route' => 'guide.dos-and-donts',
                'matches' => ['guide.dos-and-donts', 'guide.emergency'],
                'color' => 'emerald',
                'icon' => 'shield',
            ],
            [
                'number' => '04',
                'key' => 'canteen',
                'title' => 'Kantin & Layanan',
                'subtitle' => 'Tap ID non-tunai, jadwal shift & aturan makan',
                'route' => 'guide.canteen',
                'matches' => ['guide.canteen'],
                'color' => 'rose',
                'icon' => 'utensils',
            ],
            [
                'number' => '05',
                'key' => 'attendance',
                'title' => 'Panduan Absensi',
                'subtitle' => 'Gerbang tap ID, jadwal shift & portal cuti',
                'route' => 'guide.attendance',
                'matches' => ['guide.attendance'],
                'color' => 'blue',
                'icon' => 'clock',
            ],
            [
                'number' => '06',
                'key' => 'support',
                'title' => 'Bantuan & Kontak',
                'subtitle' => 'Helpdesk IT, Umum (GA), HR & Darurat 24 Jam',
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
                'title' => 'Pembukaan',
                'desc' => 'Logo perusahaan, gedung kantor baru, adegan penyambutan',
                'image' => '/images/plant-exterior.jpg',
                'tag' => 'Gedung Kantor Baru',
                'sub' => 'Modern dan Nyaman',
                'link_route' => 'guide.office-and-plant',
            ],
            [
                'id' => 2,
                'time' => '0:10 - 0:30',
                'seconds' => 10,
                'title' => 'Sambutan Manajemen',
                'desc' => 'Pesan Manajemen mengenai relokasi dan visi masa depan',
                'image' => '/images/management-office.jpg',
                'tag' => 'Visi Manajemen',
                'sub' => 'SDM • Keselamatan • Pertumbuhan',
                'link_route' => 'guide.message',
            ],
            [
                'id' => 3,
                'time' => '0:30 - 0:45',
                'seconds' => 30,
                'title' => 'Kantor & Pabrik Baru',
                'desc' => 'Menampilkan gedung kantor baru, area pabrik, dan fasilitas utama',
                'image' => '/images/hero-office.jpg',
                'tag' => 'Area Kantor',
                'sub' => 'Ruang Kerja Kolaboratif',
                'link_route' => 'guide.map',
            ],
            [
                'id' => 4,
                'time' => '0:45 - 1:00',
                'seconds' => 45,
                'title' => 'Tempat Kerja Lebih Baik',
                'desc' => 'Lingkungan kerja yang aman, nyaman, dan efisien',
                'image' => '/images/meeting-room.jpg',
                'tag' => 'Ruang Rapat',
                'sub' => 'Untuk Kolaborasi Lebih Baik',
                'link_route' => 'guide.facilities',
            ],
            [
                'id' => 5,
                'time' => '1:00 - 1:15',
                'seconds' => 60,
                'title' => 'Bersama Menuju Masa Depan',
                'desc' => 'Karyawan, kerja tim, dan peluang baru di pabrik Karawang',
                'image' => '/images/facilities-office.jpg',
                'tag' => 'Kantin & Pabrik',
                'sub' => 'Sehat & Berkelanjutan',
                'link_route' => 'guide.canteen',
            ],
            [
                'id' => 6,
                'time' => '1:15 - 1:18',
                'seconds' => 75,
                'title' => 'Penutup',
                'desc' => 'Ucapan terima kasih dan selamat datang — Melangkah Bersama',
                'image' => '/images/floorplan-preview.jpg',
                'tag' => 'Area Pabrik',
                'sub' => 'Canggih & Berkelanjutan',
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
            ['title' => 'Gedung Kantor Baru', 'subtitle' => 'Modern dan Nyaman', 'image' => '/images/plant-exterior.jpg', 'chapter' => 0, 'route' => 'guide.office-and-plant'],
            ['title' => 'Area Kantor', 'subtitle' => 'Ruang Kerja Kolaboratif', 'image' => '/images/facilities-office.jpg', 'chapter' => 2, 'route' => 'guide.map'],
            ['title' => 'Ruang Rapat', 'subtitle' => 'Untuk Kolaborasi Lebih Baik', 'image' => '/images/meeting-room.jpg', 'chapter' => 3, 'route' => 'guide.facilities'],
            ['title' => 'Kantin', 'subtitle' => 'Sehat & Nyaman', 'image' => '/images/management-office.jpg', 'chapter' => 4, 'route' => 'guide.canteen'],
            ['title' => 'Area Pabrik', 'subtitle' => 'Canggih & Berkelanjutan', 'image' => '/images/hero-office.jpg', 'chapter' => 4, 'route' => 'guide.office-and-plant'],
        ];
    }

    /**
     * Default 5-step "Cara Penggunaan" workflow per facility category.
     */
    public static function defaultFacilitySteps(string $category, string $facilityName = ''): array
    {
        return match ($category) {
            'meeting' => [
                ['step' => 1, 'title' => 'Pesan via Portal SSO', 'badge' => 'Portal SSO', 'desc' => 'Reservasi ruang rapat melalui Portal SSO Perusahaan (Sistem Ruang Rapat).', 'preview_title' => 'Portal SSO', 'preview_status' => 'Booking Terkonfirmasi'],
                ['step' => 2, 'title' => 'Cek Jadwal di Tablet Ruangan', 'badge' => 'Tablet Ruangan', 'desc' => 'Di pintu ruangan, periksa tablet ruangan untuk melihat jadwal dan status (Tersedia / Dipakai).', 'preview_title' => 'Layar Ruangan', 'preview_status' => 'TERSEDIA / DIPAKAI'],
                ['step' => 3, 'title' => 'Hubungkan Perangkat', 'badge' => 'HDMI / Nirkabel', 'desc' => 'Sambungkan laptop Anda ke layar ruangan menggunakan kabel HDMI atau koneksi nirkabel.', 'preview_title' => 'Sambungkan Layar', 'preview_status' => 'HDMI / Nirkabel'],
                ['step' => 4, 'title' => 'Mulai Rapat', 'badge' => 'AV & VC Siap', 'desc' => 'Mulai rapat Anda dan gunakan kamera, mikrofon, serta speaker sesuai kebutuhan.', 'preview_title' => 'Konferensi Video', 'preview_status' => 'Panggilan Aktif'],
                ['step' => 5, 'title' => 'Selesai & Rapikan', 'badge' => 'Reset 5R', 'desc' => 'Akhiri rapat, lepaskan perangkat Anda, dan rapikan ruangan untuk pengguna berikutnya.', 'preview_title' => 'Rapat Selesai', 'preview_status' => 'Check-Out OK'],
            ],
            'dining' => [
                ['step' => 1, 'title' => 'Cek Menu Harian & Jam Shift', 'badge' => '11:00 - 14:00', 'desc' => 'Lihat papan menu gizi seimbang hari ini dan ikuti jadwal shift departemen Anda.', 'preview_title' => 'Menu Hari Ini', 'preview_status' => 'Antrean Shift'],
                ['step' => 2, 'title' => 'Cuci Tangan Terlebih Dahulu', 'badge' => 'Stasiun Higienis', 'desc' => 'Gunakan wastafel sensor otomatis dan hand sanitizer di pintu masuk kantin.', 'preview_title' => 'Sanitasi Tangan', 'preview_status' => 'Sensor Siap'],
                ['step' => 3, 'title' => 'Tap Kartu ID Pegawai', 'badge' => 'Tap Non-Tunai', 'desc' => 'Pilih konter makanan Anda lalu tempelkan kartu ID RFID pada mesin pembaca di kantin.', 'preview_title' => 'Tap Kartu RFID', 'preview_status' => 'Makan Tercatat'],
                ['step' => 4, 'title' => 'Makan di Area Duduk Tersedia', 'badge' => '350 Kursi', 'desc' => 'Jaga jalur jalan tetap leluasa dan hindari menandai kursi kosong saat jam ramai makan siang.', 'preview_title' => 'Area Makan', 'preview_status' => 'Sejuk Ber-AC'],
                ['step' => 5, 'title' => 'Pilah Sampah & Kembalikan Baki', 'badge' => 'Kantin 5R', 'desc' => 'Pisahkan sisa makanan organik, plastik, lalu kembalikan baki ke rak pengembalian.', 'preview_title' => 'Rak Baki', 'preview_status' => 'Tertata Bersih'],
            ],
            'workspace' => [
                ['step' => 1, 'title' => 'Temukan Zona Kerja Anda', 'badge' => 'Meja & Loker', 'desc' => 'Periksa kode lantai dan sayap ruangan pada QR Tent Card meja Anda atau Denah Kantor.', 'preview_title' => 'Pencari Zona', 'preview_status' => 'Lantai 2'],
                ['step' => 2, 'title' => 'Atur Meja Ergonomis', 'badge' => 'Dual Monitor', 'desc' => 'Sambungkan ke colokan USB-C / daya di meja dan sesuaikan tinggi kursi agar nyaman.', 'preview_title' => 'Area Kerja', 'preview_status' => 'Daya Siap'],
                ['step' => 3, 'title' => 'Simpan Barang di Loker', 'badge' => 'Loker RFID', 'desc' => 'Simpan tas dan barang pribadi di dalam loker RFID agar lorong kerja tetap rapi dan bebas hambatan.', 'preview_title' => 'Akses Loker', 'preview_status' => 'Terkunci Aman'],
                ['step' => 4, 'title' => 'Gunakan Phone Booth untuk Telepon', 'badge' => 'Etiket Fokus', 'desc' => 'Gunakan bilik telepon (phone booth) atau area kolaborasi untuk panggilan video berdurasi lama.', 'preview_title' => 'Bilik Telepon', 'preview_status' => 'Zona Tenang'],
                ['step' => 5, 'title' => 'Rapikan Meja Sebelum Pulang', 'badge' => 'Win+L & 5R', 'desc' => 'Kunci layar laptop Anda, simpan dokumen penting di laci, dan pastikan meja bersih.', 'preview_title' => 'Meja Bersih', 'preview_status' => 'Terverifikasi 5R'],
            ],
            'wellness' => [
                ['step' => 1, 'title' => 'Perhatikan Tata Tertib Ruang', 'badge' => 'Cek Rambu', 'desc' => 'Ikuti petunjuk masuk (lepas alas kaki di Musholla atau cek akses Ruang Laktasi).', 'preview_title' => 'Akses Ruangan', 'preview_status' => 'Buka 24 Jam / Shift'],
                ['step' => 2, 'title' => 'Gunakan Fasilitas dengan Bersih', 'badge' => 'Terjaga Higienis', 'desc' => 'Gunakan keran wudhu, kulkas khusus ASI, atau kursi istirahat dengan tertib.', 'preview_title' => 'Fasilitas Siap', 'preview_status' => 'Higienis'],
                ['step' => 3, 'title' => 'Jaga Ketenangan Ruangan', 'badge' => 'Zona Tenang', 'desc' => 'Atur nada dering ponsel ke mode senyap dan berbicara pelan demi kenyamanan bersama.', 'preview_title' => 'Suasana Tenang', 'preview_status' => 'Nyaman'],
                ['step' => 4, 'title' => 'Beri Label Penyimpanan (Laktasi)', 'badge' => 'Nama & Waktu', 'desc' => 'Jika menyimpan ASI di pendingin, tempelkan label nama dan jam penyimpanan secara jelas.', 'preview_title' => 'Label Barang', 'preview_status' => 'Terlabeli'],
                ['step' => 5, 'title' => 'Tinggalkan dalam Keadaan Rapi', 'badge' => 'Peduli 5R', 'desc' => 'Rapikan sandal/perlengkapan dan beri tahu tim Umum (GA) bila perlengkapan habis.', 'preview_title' => 'Selesai', 'preview_status' => 'Siap Dipakai'],
            ],
            'safety' => [
                ['step' => 1, 'title' => 'Laporkan Kondisi Segera', 'badge' => 'Atasan / HSE', 'desc' => 'Beri tahu atasan atau rekan terdekat sebelum menuju ruang klinik kesehatan.', 'preview_title' => 'Laporan Awal', 'preview_status' => 'Info HSE'],
                ['step' => 2, 'title' => 'Berjalan Lewat Jalur Hijau', 'badge' => 'Rute Aman', 'desc' => 'Ikuti jalur pejalan kaki berwarna hijau di Lantai 1/Pabrik menuju Klinik & P3K.', 'preview_title' => 'Jalur Hijau', 'preview_status' => 'Rute Teraman'],
                ['step' => 3, 'title' => 'Registrasi dengan Paramedis Jaga', 'badge' => 'Medis 24/7', 'desc' => 'Tunjukkan kartu identitas pegawai di meja klinik untuk pemeriksaan tanda vital.', 'preview_title' => 'Triase Medis', 'preview_status' => 'Perawat Siaga'],
                ['step' => 4, 'title' => 'Dapatkan Penanganan / Istirahat', 'badge' => 'P3K / AED', 'desc' => 'Beristirahat di tempat tidur observasi atau terima rujukan darurat melalui ambulans siaga.', 'preview_title' => 'Ruang Rawat', 'preview_status' => 'Terkendali'],
                ['step' => 5, 'title' => 'Catat di Formulir K3 / Izin Medis', 'badge' => 'Nihil Kecelakaan', 'desc' => 'Pastikan catatan medis atau insiden tercatat guna pencegahan keselamatan kerja.', 'preview_title' => 'Log Keselamatan', 'preview_status' => 'Tercatat'],
            ],
            default => [ // 'service' (Lobi, Tamu, Resepsionis, Auditorium, Parkir)
                ['step' => 1, 'title' => 'Pra-Registrasi atau Lapor di Lobi', 'badge' => 'Kios Digital', 'desc' => 'Lakukan check-in di tablet Resepsionis Virtual atau pindai kartu RFID di gerbang masuk.', 'preview_title' => 'Meja Check-In', 'preview_status' => 'Verifikasi ID'],
                ['step' => 2, 'title' => 'Konfirmasi Tuan Rumah / Jadwal', 'badge' => 'Notifikasi PIC', 'desc' => 'Sistem otomatis menghubungi PIC yang dituju atau menampilkan informasi arah ruangan.', 'preview_title' => 'Panggilan PIC', 'preview_status' => 'Disetujui'],
                ['step' => 3, 'title' => 'Kenakan Tanda Pengenal / Ikuti Aturan', 'badge' => 'Kebijakan K3', 'desc' => 'Kenakan kartu Tamu dengan jelas di dalam gedung atau ikuti parkir mundur di area luar.', 'preview_title' => 'Kartu Akses', 'preview_status' => 'Aktif'],
                ['step' => 4, 'title' => 'Gunakan Ruang Tunggu & Wi-Fi', 'badge' => 'Wi-Fi Tamu', 'desc' => 'Gunakan Wi-Fi tamu dan tunggu dengan nyaman di Lobi Utama hingga dijemput PIC Anda.', 'preview_title' => 'Ruang Tunggu', 'preview_status' => 'Terhubung'],
                ['step' => 5, 'title' => 'Check-Out & Kembalikan Kartu', 'badge' => 'Pindai Keluar', 'desc' => 'Kembalikan Kartu Tamu ke resepsionis atau pindai keluar di gerbang saat selesai.', 'preview_title' => 'Check-Out', 'preview_status' => 'Selesai'],
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
                'code' => 'Lt. 1',
                'building' => 'Gedung Utama',
                'title' => 'Gedung Utama – Lantai 1',
                'subtitle' => 'Lobi, Kantin, Klinik, Musholla & Area Resepsionis Tamu',
                'start' => ['x' => 44, 'y' => 92, 'label' => 'Pintu Masuk Utama & Pos Keamanan'],
                'corridor_y' => 52,
                'corridor_x' => 50,
                'rooms' => [
                    ['code' => 'MO-101', 'name' => 'Lobi Utama & Resepsionis', 'label' => "LOBI UTAMA\n& RESEPSIONIS", 'icon' => '🏢', 'group' => 'Area Kerja', 'color' => 'bg-sky-200 border-sky-400 text-sky-900', 'x' => 8, 'y' => 14, 'w' => 24, 'h' => 30, 'cx' => 20, 'cy' => 29, 'capacity' => '50 Tamu', 'facilities' => 'Kios Pengunjung, Resepsionis Virtual, Wi-Fi Tamu', 'usage' => 'Registrasi tamu & penerimaan kunjungan bisnis', 'book' => 'Portal Pengunjung Online / Resepsionis', 'image' => '/images/hero-office.jpg'],
                    ['code' => 'MO-106', 'name' => 'Auditorium & Ruang Pelatihan', 'label' => "AULA /\nAUDITORIUM", 'icon' => '📽️', 'group' => 'Ruang Rapat', 'color' => 'bg-pink-200 border-pink-400 text-pink-900', 'x' => 34, 'y' => 14, 'w' => 28, 'h' => 30, 'cx' => 48, 'cy' => 29, 'capacity' => '120 Orang', 'facilities' => 'Layar LED, Mikrofon Nirkabel, Sistem Audio', 'usage' => 'Townhall, pelatihan, dan sosialisasi karyawan', 'book' => 'Melalui Portal SSO (Bagian Umum / GA)', 'image' => '/images/meeting-room.jpg'],
                    ['code' => 'MO-102', 'name' => 'Kantin Utama & Cafeteria', 'label' => "KANTIN UTAMA\n(350 KURSI)", 'icon' => '☕', 'group' => 'Pantry / Santai', 'color' => 'bg-amber-200 border-amber-400 text-amber-900', 'x' => 64, 'y' => 14, 'w' => 28, 'h' => 32, 'cx' => 78, 'cy' => 30, 'capacity' => '350 Orang', 'facilities' => 'Tap ID Non-Tunai, Dispenser, Tempat Cuci Tangan', 'usage' => 'Makan siang shift & area istirahat', 'book' => 'Akses Tap Kartu Pegawai (11:00 - 14:00)', 'image' => '/images/management-office.jpg'],
                    ['code' => 'MO-105', 'name' => 'Titik Kumpul Evakuasi', 'label' => "TITIK KUMPUL\nEVAKUASI 1", 'icon' => '🏃', 'group' => 'Jalur Darurat', 'color' => 'bg-emerald-200 border-emerald-500 text-emerald-900', 'x' => 8, 'y' => 60, 'w' => 22, 'h' => 26, 'cx' => 19, 'cy' => 73, 'capacity' => '500 Orang', 'facilities' => 'Rambu Darurat, Pengeras Suara, Kotak P3K', 'usage' => 'Titik berkumpul resmi saat alarm darurat', 'book' => 'Akses Terbuka Darurat 24/7', 'image' => '/images/plant-exterior.jpg'],
                    ['code' => 'MO-104', 'name' => 'Musholla Al-Ikhlas', 'label' => "MUSHOLLA\nAL-IKHLAS", 'icon' => '🕌', 'group' => 'Pantry / Santai', 'color' => 'bg-purple-200 border-purple-400 text-purple-900', 'x' => 34, 'y' => 60, 'w' => 24, 'h' => 26, 'cx' => 46, 'cy' => 73, 'capacity' => '120 Jamaah', 'facilities' => 'Tempat Wudhu Modern, Sajadah, Full AC', 'usage' => 'Area ibadah karyawan pria & wanita', 'book' => 'Buka 24 Jam (Lepas Alas Kaki)', 'image' => '/images/meeting-room.jpg'],
                    ['code' => 'MO-103', 'name' => 'Klinik Medis & P3K', 'label' => "KLINIK MEDIS\n& P3K", 'icon' => '🏥', 'group' => 'Ruang Penunjang', 'color' => 'bg-rose-200 border-rose-400 text-rose-900', 'x' => 61, 'y' => 60, 'w' => 19, 'h' => 26, 'cx' => 70, 'cy' => 73, 'capacity' => '4 Bed Pasien', 'facilities' => 'Dokter/Paramedis Jaga, AED, Ambulans 24/7', 'usage' => 'Layanan medis P3K & konsultasi kesehatan', 'book' => 'Datang Langsung / Ext. 119 Darurat', 'image' => '/images/facilities-office.jpg'],
                    ['code' => 'MO-107', 'name' => 'Toilet Lantai 1', 'label' => "TOILET\nLT. 1", 'icon' => '🚻', 'group' => 'Toilet', 'color' => 'bg-cyan-100 border-cyan-400 text-cyan-900', 'x' => 82, 'y' => 60, 'w' => 10, 'h' => 26, 'cx' => 87, 'cy' => 73, 'capacity' => 'Pria / Wanita / Difabel', 'facilities' => 'Wastafel Sensor, Pengering Tangan', 'usage' => 'Fasilitas sanitasi lantai 1', 'book' => 'Akses Umum', 'image' => '/images/hero-office.jpg'],
                ],
                'icons' => [
                    ['type' => 'exit', 'x' => 7, 'y' => 52, 'label' => 'Pintu Darurat Barat'],
                    ['type' => 'exit', 'x' => 93, 'y' => 52, 'label' => 'Pintu Penghubung Pabrik Timur'],
                    ['type' => 'apar', 'x' => 32, 'y' => 48, 'label' => 'APAR 1A'],
                    ['type' => 'apar', 'x' => 62, 'y' => 48, 'label' => 'APAR 1B'],
                    ['type' => 'stairs', 'x' => 59, 'y' => 50, 'label' => 'Tangga Utama ke Lt. 2'],
                    ['type' => 'elevator', 'x' => 29, 'y' => 47, 'label' => 'Lift Penumpang'],
                ],
            ],
            'Lantai 2' => [
                'code' => 'Lt. 2',
                'building' => 'Gedung Utama',
                'title' => 'Gedung Utama – Lantai 2',
                'subtitle' => 'Ketuk area pada denah untuk melihat detail, foto, dan petunjuk arah.',
                'start' => ['x' => 44, 'y' => 92, 'label' => 'Pintu Masuk Utama Lt. 2'],
                'corridor_y' => 31,
                'corridor_x' => 31,
                'rooms' => [
                    ['code' => 'EXEC-01', 'name' => 'R. Tamu (Direksi)', 'label' => "R. TAMU\n(DIREKSI)", 'icon' => '👥', 'group' => 'Ruang Direksi', 'color' => 'bg-[#ffcdd2] border-[#e57373] text-[#7f1d1d]', 'x' => 5, 'y' => 6, 'w' => 13, 'h' => 22, 'cx' => 11.5, 'cy' => 17, 'capacity' => '6 – 8 orang', 'facilities' => 'Sofa VIP, Layanan Teh/Kopi, Layar 4K', 'usage' => 'Penyambutan tamu eksekutif & jajaran direksi', 'book' => 'Melalui Sekretaris Direksi', 'image' => '/images/meeting-room.jpg'],
                    ['code' => 'EXEC-02', 'name' => 'Ruang Presidir', 'label' => "PRESIDIR", 'icon' => '👤', 'group' => 'Ruang Direksi', 'color' => 'bg-[#ffe0b2] border-[#ffb74d] text-[#7c2d12]', 'x' => 18.5, 'y' => 6, 'w' => 12.5, 'h' => 22, 'cx' => 24.5, 'cy' => 17, 'capacity' => 'Ruang Eksekutif', 'facilities' => 'Meja Rapat Privat, Konferensi Video, Jalur Aman', 'usage' => 'Ruang Kerja Presiden Direktur', 'book' => 'Akses Terbatas (Melalui Sekretaris)', 'image' => '/images/hero-office.jpg'],
                    ['code' => 'EXEC-03', 'name' => 'Ruang Wakil Presiden', 'label' => "WAKIL\nPRESIDIR", 'icon' => '👤', 'group' => 'Ruang Direksi', 'color' => 'bg-[#fff9c4] border-[#ffd54f] text-[#713f12]', 'x' => 31.5, 'y' => 6, 'w' => 13, 'h' => 22, 'cx' => 38, 'cy' => 17, 'capacity' => 'Ruang Eksekutif', 'facilities' => 'Meja Eksekutif, Meja Diskusi, Layar VC', 'usage' => 'Ruang Kerja Wakil Presiden Direktur', 'book' => 'Akses Terbatas (Melalui Sekretaris)', 'image' => '/images/hero-office.jpg'],
                    ['code' => 'MO-205', 'name' => 'Ruang Rapat Privat', 'label' => "R. RAPAT\nPRIVAT", 'icon' => '👥', 'group' => 'Ruang Rapat', 'color' => 'bg-[#c8e6c9] border-[#66bb6a] text-[#14532d]', 'x' => 45, 'y' => 6, 'w' => 13, 'h' => 22, 'cx' => 51.5, 'cy' => 17, 'capacity' => '8 – 12 orang', 'facilities' => 'Layar Pintar 4K, Kamera (VC), Kaca Kedap Suara', 'usage' => 'Rapat internal manajemen & diskusi rahasia HR', 'book' => 'Melalui Sistem Ruang Rapat (Outlook / Portal Web)', 'image' => '/images/meeting-room.jpg', 'facility_slug' => 'ruang-rapat-sakura'],
                    ['code' => 'EXEC-04', 'name' => 'Ruang Direktur 1', 'label' => "DIREKTUR 1", 'icon' => '👤', 'group' => 'Ruang Direksi', 'color' => 'bg-[#bbdefb] border-[#64b5f6] text-[#1e3a8a]', 'x' => 58.5, 'y' => 6, 'w' => 12.5, 'h' => 22, 'cx' => 64.5, 'cy' => 17, 'capacity' => 'Ruang Direktur', 'facilities' => 'Meja Kerja Eksekutif, Sudut Rapat Privat', 'usage' => 'Ruang Kerja Direktur 1', 'book' => 'Melalui Sekretaris Direksi', 'image' => '/images/facilities-office.jpg'],
                    ['code' => 'EXEC-05', 'name' => 'Ruang Direktur 2', 'label' => "DIREKTUR 2", 'icon' => '👤', 'group' => 'Ruang Direksi', 'color' => 'bg-[#bbdefb] border-[#64b5f6] text-[#1e3a8a]', 'x' => 71.5, 'y' => 6, 'w' => 12.5, 'h' => 22, 'cx' => 77.5, 'cy' => 17, 'capacity' => 'Ruang Direktur', 'facilities' => 'Meja Kerja Eksekutif, Sudut Rapat Privat', 'usage' => 'Ruang Kerja Direktur 2', 'book' => 'Melalui Sekretaris Direksi', 'image' => '/images/facilities-office.jpg'],
                    ['code' => 'MO-206', 'name' => 'R. Perpus (Perpustakaan)', 'label' => "R. PERPUS", 'icon' => '📖', 'group' => 'Ruang Penunjang', 'color' => 'bg-[#e1bee7] border-[#ba68c8] text-[#4a148c]', 'x' => 84.5, 'y' => 6, 'w' => 11, 'h' => 22, 'cx' => 90, 'cy' => 17, 'capacity' => '12 – 15 orang', 'facilities' => 'Meja Baca Tenang, Arsip Teknis, Printer', 'usage' => 'Perpustakaan standar teknik & ruang baca tenang', 'book' => 'Akses Terbuka untuk Karyawan', 'image' => '/images/facilities-office.jpg'],
                    ['code' => 'MR-04', 'name' => 'Ruang Meeting 4', 'label' => "MEETING 4", 'icon' => '👥', 'group' => 'Ruang Rapat', 'color' => 'bg-[#ffcdd2] border-[#e57373] text-[#881337]', 'x' => 5, 'y' => 33, 'w' => 13, 'h' => 19, 'cx' => 11.5, 'cy' => 42.5, 'capacity' => '6 – 8 orang', 'facilities' => 'Layar, Kamera, Mikrofon, Papan Tulis', 'usage' => 'Diskusi tim lintas departemen', 'book' => 'Melalui Sistem Ruang Rapat (Outlook / Portal Web)', 'image' => '/images/meeting-room.jpg', 'facility_slug' => 'meeting-room-5'],
                    ['code' => 'MR-05', 'name' => 'Meeting Room 5', 'label' => "MEETING 5", 'icon' => '👥', 'group' => 'Ruang Rapat', 'color' => 'bg-[#f8bbd0] border-[#ec407a] text-[#831843]', 'x' => 5, 'y' => 53, 'w' => 13, 'h' => 19, 'cx' => 11.5, 'cy' => 62.5, 'capacity' => '8–10 orang', 'facilities' => 'Layar 4K, Kamera, Mikrofon, Konferensi Video', 'usage' => 'Untuk rapat internal & konferensi video', 'book' => 'Melalui Sistem Ruang Rapat (Outlook / Portal Web)', 'image' => '/images/meeting-room.jpg', 'facility_slug' => 'meeting-room-5'],
                    ['code' => 'MO-202', 'name' => 'Area Manager & Staff', 'label' => "AREA MANAGER\n& STAFF", 'icon' => '💼', 'group' => 'Area Kerja', 'color' => 'bg-white/95 border-slate-300 text-[#0f2e54]', 'x' => 35, 'y' => 50, 'w' => 20, 'h' => 10, 'cx' => 45, 'cy' => 55, 'capacity' => '180 Meja Kerja', 'facilities' => 'Siap Dual Monitor, Port USB-C, Kursi Ergonomis, Loker', 'usage' => 'Ruang kerja terbuka kolaboratif untuk Manager hingga Staff', 'book' => 'Meja Terdaftar (Lihat QR Tent Card)', 'image' => '/images/facilities-office.jpg', 'facility_slug' => 'open-workspace-collaboration'],
                    ['code' => 'MO-204', 'name' => 'Area Pantry', 'label' => "AREA\nPANTRY", 'icon' => '☕', 'group' => 'Pantry / Santai', 'color' => 'bg-white/95 border-amber-300 text-slate-800', 'x' => 58, 'y' => 58, 'w' => 9.5, 'h' => 24, 'cx' => 62.5, 'cy' => 70, 'capacity' => '20 – 24 orang', 'facilities' => 'Mesin Kopi, Dispenser Air, Microwave, Kursi Santai', 'usage' => 'Area penyegaran & istirahat santai karyawan', 'book' => 'Akses Terbuka (Patuhi Aturan 5R)', 'image' => '/images/management-office.jpg'],
                    ['code' => 'REST-2F', 'name' => 'Toilet Lantai 2', 'label' => "🚹 🚺", 'icon' => '🚻', 'group' => 'Toilet', 'color' => 'bg-[#dbeafe] border-[#60a5fa] text-[#1e3a8a]', 'x' => 74, 'y' => 34, 'w' => 10, 'h' => 22, 'cx' => 79, 'cy' => 45, 'capacity' => 'Pria & Wanita', 'facilities' => 'Wastafel Sensor, Pengering Tangan, Pembersih Tangan', 'usage' => 'Toilet karyawan & tamu Lantai 2', 'book' => 'Akses Terbuka', 'image' => '/images/hero-office.jpg'],
                    ['code' => 'SUP-01', 'name' => 'R. Server', 'label' => "R. SERVER", 'icon' => '🖧', 'group' => 'Ruang Penunjang', 'color' => 'bg-[#b2ebf2] border-[#26c6da] text-[#083344]', 'x' => 84.5, 'y' => 45, 'w' => 11, 'h' => 21, 'cx' => 90, 'cy' => 55.5, 'capacity' => 'Khusus Tim IT', 'facilities' => 'Rak Server, Pendingin Presisi, Pemadam Gas Otomatis', 'usage' => 'Ruang pusat jaringan & server (Infrastruktur IT)', 'book' => 'Akses Biometrik (Departemen IT)', 'image' => '/images/facilities-office.jpg'],
                    ['code' => 'SUP-02', 'name' => 'R. UPS', 'label' => "R. UPS", 'icon' => '🔋', 'group' => 'Ruang Penunjang', 'color' => 'bg-[#bfdbfe] border-[#3b82f6] text-[#1e3a8a]', 'x' => 88, 'y' => 67, 'w' => 7.5, 'h' => 21, 'cx' => 91.5, 'cy' => 77.5, 'capacity' => 'Khusus GA / Teknisi', 'facilities' => 'Uninterruptible Power Supply, Bank Baterai', 'usage' => 'Distribusi daya cadangan darurat gedung', 'book' => 'Khusus Teknisi Berwenang', 'image' => '/images/plant-exterior.jpg'],
                ],
                'icons' => [
                    ['type' => 'apar', 'x' => 19, 'y' => 30, 'label' => 'Alat Pemadam Api Ringan (APAR 2A)'],
                    ['type' => 'apar', 'x' => 31, 'y' => 30, 'label' => 'Alat Pemadam Api Ringan (APAR 2B)'],
                    ['type' => 'apar', 'x' => 44, 'y' => 30, 'label' => 'Alat Pemadam Api Ringan (APAR 2C)'],
                    ['type' => 'apar', 'x' => 19, 'y' => 72, 'label' => 'Alat Pemadam Api Ringan (APAR 2D)'],
                    ['type' => 'apar', 'x' => 36, 'y' => 89, 'label' => 'Alat Pemadam Api Ringan (APAR 2E)'],
                    ['type' => 'apar', 'x' => 72, 'y' => 89, 'label' => 'Alat Pemadam Api Ringan (APAR 2F)'],
                    ['type' => 'exit', 'x' => 19, 'y' => 42, 'label' => 'Jalur Evakuasi Darurat'],
                    ['type' => 'exit', 'x' => 6, 'y' => 74, 'label' => 'Tangga Darurat Sayap Barat'],
                    ['type' => 'exit', 'x' => 9, 'y' => 89, 'label' => 'Pintu Keluar Darurat Barat Daya'],
                    ['type' => 'exit', 'x' => 75, 'y' => 89, 'label' => 'Pintu Keluar Darurat Tenggara'],
                ],
            ],
            'Ground Floor' => [
                'code' => 'Pabrik',
                'building' => 'Pabrik 1 & Pabrik 2',
                'title' => 'Kompleks Pabrik & Area Utama',
                'subtitle' => 'Lini produksi, pusat logistik, pengisian EV & jalur hijau pejalan kaki',
                'start' => ['x' => 44, 'y' => 92, 'label' => 'Gerbang Penghubung Gedung Utama'],
                'corridor_y' => 82,
                'corridor_x' => 50,
                'rooms' => [
                    ['code' => 'PL-01', 'name' => 'Pabrik 1: Pemesinan & Pengecoran', 'label' => "PABRIK 1:\nPEMESINAN & COR", 'icon' => '⚙️', 'group' => 'Area Kerja', 'color' => 'bg-slate-200 border-slate-400 text-slate-900', 'x' => 8, 'y' => 14, 'w' => 38, 'h' => 56, 'cx' => 27, 'cy' => 42, 'capacity' => 'Area Produksi', 'facilities' => 'CNC Otomatis, Lini Pengecoran, Jalur Hijau', 'usage' => 'Produksi rotor & kaliper rem (Wajib APD Lengkap)', 'book' => 'Izin Masuk Supervisor (Ext. 301)', 'image' => '/images/plant-exterior.jpg'],
                    ['code' => 'PL-02', 'name' => 'Pabrik 2: Perakitan Otomatis', 'label' => "PABRIK 2:\nPERAKITAN OTOMATIS", 'icon' => '🔧', 'group' => 'Area Kerja', 'color' => 'bg-indigo-200 border-indigo-400 text-indigo-900', 'x' => 50, 'y' => 14, 'w' => 42, 'h' => 38, 'cx' => 71, 'cy' => 33, 'capacity' => 'Perakitan Bersih', 'facilities' => 'Lini Robotik, Uji Kebocoran, Inspeksi Kualitas', 'usage' => 'Perakitan akhir komponen rem OEM', 'book' => 'Supervisor Perakitan (Ext. 302)', 'image' => '/images/hero-office.jpg'],
                    ['code' => 'PL-03', 'name' => 'Pusat Logistik & Dermaga Muat', 'label' => "PUSAT LOGISTIK\n& DERMAGA MUAT", 'icon' => '🚚', 'group' => 'Ruang Penunjang', 'color' => 'bg-amber-200 border-amber-400 text-amber-900', 'x' => 50, 'y' => 56, 'w' => 42, 'h' => 20, 'cx' => 71, 'cy' => 66, 'capacity' => '6 Jalur Muat', 'facilities' => 'Dock Leveler, Jalur Lintasan Forklift', 'usage' => 'Penerimaan bahan baku & pengiriman barang jadi', 'book' => 'Meja Logistik (Ext. 350)', 'image' => '/images/plant-exterior.jpg'],
                ],
                'icons' => [
                    ['type' => 'exit', 'x' => 6, 'y' => 84, 'label' => 'Pintu Evakuasi Pabrik Barat'],
                    ['type' => 'exit', 'x' => 93, 'y' => 84, 'label' => 'Pintu Evakuasi Halaman Timur'],
                    ['type' => 'apar', 'x' => 48, 'y' => 50, 'label' => 'Hydrant & APAR P1/P2'],
                    ['type' => 'restroom', 'x' => 48, 'y' => 20, 'label' => 'Loker & Toilet Pabrik'],
                ],
            ],
        ];
    }
}
