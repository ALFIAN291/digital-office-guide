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

        $primary = office_media($facility, 'image_path', 'images/facilities-office.jpg');
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
                'subtitle' => 'Lobi, Resepsionis, Showroom, Area Kerja & Fasilitas Tamu Lantai 1',
                'map_image' => '/images/office-map-1f.jpg',
                'start' => ['x' => 70.5, 'y' => 66, 'label' => 'Pintu Masuk Utama & Resepsionis'],
                'corridor_y' => 50,
                'corridor_x' => 65,
                'rooms' => [
                    ['code' => 'MO-101', 'name' => 'Lobi Utama & Resepsionis', 'label' => 'Resepsionis & Lobi', 'icon' => '🏢', 'group' => 'Area Kerja', 'color' => 'bg-sky-600 text-white border-white', 'x' => 69.5, 'y' => 45, 'cx' => 69.5, 'cy' => 45, 'capacity' => '50 Tamu', 'facilities' => 'Kios Pengunjung, Resepsionis Virtual, Wi-Fi Tamu', 'usage' => 'Registrasi tamu & penerimaan kunjungan bisnis', 'book' => 'Portal Pengunjung Online / Resepsionis', 'image' => '/images/hero-office.jpg'],
                    ['code' => 'MO-109', 'name' => 'Area Kerja Utama Lantai 1', 'label' => 'Area Kerja Lt. 1', 'icon' => '💼', 'group' => 'Area Kerja', 'color' => 'bg-[#0f2e54] text-white border-white', 'x' => 42, 'y' => 52, 'cx' => 42, 'cy' => 52, 'capacity' => '150 Meja Kerja', 'facilities' => 'Meja Kerja Terbuka, Dual Monitor, Port USB-C', 'usage' => 'Area operasional & layanan umum karyawan Lantai 1', 'book' => 'Meja Terdaftar (Lihat QR Tent Card)', 'image' => '/images/facilities-office.jpg', 'facility_slug' => 'open-workspace-collaboration'],
                    ['code' => 'MO-106', 'name' => 'Showroom & Galeri Produk', 'label' => 'Showroom Utama', 'icon' => '📽️', 'group' => 'Ruang Rapat', 'color' => 'bg-amber-600 text-white border-white', 'x' => 86.5, 'y' => 58, 'cx' => 86.5, 'cy' => 58, 'capacity' => '80 Orang', 'facilities' => 'Display Produk Rem, Layar LED, Sistem Audio', 'usage' => 'Presentasi teknologi produk, tamu OEM & briefing', 'book' => 'Melalui Portal SSO (Bagian Umum / GA)', 'image' => '/images/meeting-room.jpg'],
                    ['code' => 'MO-108', 'name' => 'Galeri & Ruang Display Utara', 'label' => 'Galeri Utara', 'icon' => '🏛️', 'group' => 'Ruang Penunjang', 'color' => 'bg-purple-600 text-white border-white', 'x' => 86.5, 'y' => 39, 'cx' => 86.5, 'cy' => 39, 'capacity' => '30 Orang', 'facilities' => 'Panel Informasi, Arsip Sejarah, Area Diskusi', 'usage' => 'Pameran sejarah & standar mutu Akebono', 'book' => 'Akses Terjadwal (Resepsionis)', 'image' => '/images/facilities-office.jpg'],
                    ['code' => 'MO-102', 'name' => 'Pantry & Area Istirahat Barat', 'label' => 'Pantry Barat', 'icon' => '☕', 'group' => 'Pantry / Santai', 'color' => 'bg-emerald-600 text-white border-white', 'x' => 13.5, 'y' => 31, 'cx' => 13.5, 'cy' => 31, 'capacity' => '25 Orang', 'facilities' => 'Dispenser, Kulkas, Meja Makan, Wastafel', 'usage' => 'Istirahat makan & penyegaran karyawan', 'book' => 'Akses Tap Kartu Pegawai', 'image' => '/images/management-office.jpg'],
                    ['code' => 'MO-110', 'name' => 'Ruang Rapat Lantai 1', 'label' => 'Ruang Rapat 1F', 'icon' => '👥', 'group' => 'Ruang Rapat', 'color' => 'bg-[#0066dc] text-white border-white', 'x' => 21.5, 'y' => 31, 'cx' => 21.5, 'cy' => 31, 'capacity' => '8 Orang', 'facilities' => 'Layar 4K, Konferensi Video, Papan Tulis', 'usage' => 'Rapat tamu & koordinasi operasional Lantai 1', 'book' => 'Melalui Portal SSO / Resepsionis', 'image' => '/images/meeting-room.jpg', 'facility_slug' => 'meeting-room-5'],
                    ['code' => 'MO-112', 'name' => 'Ruang Koordinasi Barat 1', 'label' => 'R. Koordinasi 1', 'icon' => '👤', 'group' => 'Ruang Direksi', 'color' => 'bg-blue-700 text-white border-white', 'x' => 35, 'y' => 31, 'cx' => 35, 'cy' => 31, 'capacity' => '4 Orang', 'facilities' => 'Meja Kerja Kaca, Akses Wi-Fi Kantor', 'usage' => 'Ruang koordinator layanan umum & HRD Lantai 1', 'book' => 'Hubungi Resepsionis Utama', 'image' => '/images/facilities-office.jpg'],
                    ['code' => 'MO-113', 'name' => 'Ruang Koordinasi Barat 2', 'label' => 'R. Koordinasi 2', 'icon' => '👤', 'group' => 'Ruang Direksi', 'color' => 'bg-blue-700 text-white border-white', 'x' => 42, 'y' => 31, 'cx' => 42, 'cy' => 31, 'capacity' => '4 Orang', 'facilities' => 'Meja Kerja Kaca, Area Konsultasi Karyawan', 'usage' => 'Layanan konsultasi HR & GA Lantai 1', 'book' => 'Hubungi Resepsionis Utama', 'image' => '/images/hero-office.jpg'],
                    ['code' => 'MO-114', 'name' => 'Ruang Rapat Tamu 1', 'label' => 'R. Rapat Tamu 1', 'icon' => '👥', 'group' => 'Ruang Rapat', 'color' => 'bg-emerald-600 text-white border-white', 'x' => 48.5, 'y' => 31, 'cx' => 48.5, 'cy' => 31, 'capacity' => '6 Orang', 'facilities' => 'Meja Bundar/Rapat, Layar TV, Wi-Fi Tamu', 'usage' => 'Penerimaan vendor & rapat tamu eksternal', 'book' => 'Melalui Resepsionis / Portal SSO', 'image' => '/images/meeting-room.jpg'],
                    ['code' => 'MO-115', 'name' => 'Ruang Rapat Tamu 2', 'label' => 'R. Rapat Tamu 2', 'icon' => '👥', 'group' => 'Ruang Rapat', 'color' => 'bg-emerald-600 text-white border-white', 'x' => 53.8, 'y' => 31, 'cx' => 53.8, 'cy' => 31, 'capacity' => '6 Orang', 'facilities' => 'Meja Rapat Kaca, Layar Presentasi', 'usage' => 'Rapat supplier & koordinasi logistik tamu', 'book' => 'Melalui Resepsionis / Portal SSO', 'image' => '/images/meeting-room.jpg'],
                    ['code' => 'MO-111', 'name' => 'Lounge & Tangga Spiral Lantai 1', 'label' => 'Lounge Barat', 'icon' => '🛋️', 'group' => 'Pantry / Santai', 'color' => 'bg-teal-600 text-white border-white', 'x' => 16.5, 'y' => 46, 'cx' => 16.5, 'cy' => 46, 'capacity' => '25 Orang', 'facilities' => 'Sofa Tamu, Tangga Penghubung Lt. 2', 'usage' => 'Area santai dan akses internal ke Lantai 2', 'book' => 'Akses Umum', 'image' => '/images/facilities-office.jpg'],
                    ['code' => 'MO-116', 'name' => 'Loker & Area Utilitas Lantai 1', 'label' => 'Loker Lt. 1', 'icon' => '🔐', 'group' => 'Ruang Penunjang', 'color' => 'bg-purple-600 text-white border-white', 'x' => 10, 'y' => 58, 'cx' => 10, 'cy' => 58, 'capacity' => 'Loker Tamu & Staff', 'facilities' => 'Loker Penyimpanan, Ruang Persiapan', 'usage' => 'Penitipan barang tamu & perlengkapan operasional', 'book' => 'Akses Kartu ID / Resepsionis', 'image' => '/images/facilities-office.jpg'],
                    ['code' => 'MO-107', 'name' => 'Toilet Utama Lantai 1', 'label' => 'Toilet Lt. 1', 'icon' => '🚻', 'group' => 'Toilet', 'color' => 'bg-emerald-700 text-white border-white', 'x' => 60.5, 'y' => 58, 'cx' => 60.5, 'cy' => 58, 'capacity' => 'Pria / Wanita / Difabel', 'facilities' => 'Wastafel Sensor, Pengering Tangan', 'usage' => 'Fasilitas sanitasi lantai 1', 'book' => 'Akses Umum', 'image' => '/images/hero-office.jpg'],
                    ['code' => 'MO-105', 'name' => 'Akses Tangga & Jalur Darurat', 'label' => 'Tangga & Exit', 'icon' => '🏃', 'group' => 'Jalur Darurat', 'color' => 'bg-rose-600 text-white border-white', 'x' => 74.5, 'y' => 57, 'cx' => 74.5, 'cy' => 57, 'capacity' => 'Jalur Evakuasi', 'facilities' => 'Tangga Utama, Tangga Spiral, Rambu Darurat', 'usage' => 'Akses naik ke Lantai 2 & jalur evakuasi', 'book' => 'Akses Terbuka 24/7', 'image' => '/images/plant-exterior.jpg'],
                ],
                'icons' => [],
            ],
            'Lantai 2' => [
                'code' => 'Lt. 2',
                'building' => 'Gedung Utama',
                'title' => 'Gedung Utama – Lantai 2',
                'subtitle' => 'Ketuk titik ruangan pada peta Lantai 2 untuk melihat detail, foto, dan petunjuk arah.',
                'map_image' => '/images/office-map-2f.jpg',
                'start' => ['x' => 71.5, 'y' => 64, 'label' => 'Tangga Utama Lt. 2'],
                'corridor_y' => 37,
                'corridor_x' => 64,
                'rooms' => [
                    ['code' => 'MO-206', 'name' => 'R. Perpus (Perpustakaan)', 'label' => 'R. Perpus', 'icon' => '📖', 'group' => 'Ruang Penunjang', 'color' => 'bg-purple-600 text-white border-white', 'x' => 13.5, 'y' => 31, 'cx' => 13.5, 'cy' => 31, 'capacity' => '12 – 15 orang', 'facilities' => 'Meja Baca Tenang, Arsip Teknis, Printer, Pantry Mini', 'usage' => 'Perpustakaan standar teknik & ruang baca tenang', 'book' => 'Akses Terbuka untuk Karyawan', 'image' => '/images/facilities-office.jpg'],
                    ['code' => 'EXEC-05', 'name' => 'Ruang Direktur 2', 'label' => 'Direktur 2', 'icon' => '👤', 'group' => 'Ruang Direksi', 'color' => 'bg-blue-700 text-white border-white', 'x' => 20.5, 'y' => 31, 'cx' => 20.5, 'cy' => 31, 'capacity' => 'Ruang Direktur', 'facilities' => 'Meja Kerja Eksekutif, Dinding Kaca, Sudut Rapat', 'usage' => 'Ruang Kerja Direktur 2', 'book' => 'Melalui Sekretaris Direksi', 'image' => '/images/facilities-office.jpg'],
                    ['code' => 'EXEC-04', 'name' => 'Ruang Direktur 1', 'label' => 'Direktur 1', 'icon' => '👤', 'group' => 'Ruang Direksi', 'color' => 'bg-blue-700 text-white border-white', 'x' => 27.2, 'y' => 31, 'cx' => 27.2, 'cy' => 31, 'capacity' => 'Ruang Direktur', 'facilities' => 'Meja Kerja Eksekutif, Dinding Kaca, Sudut Rapat', 'usage' => 'Ruang Kerja Direktur 1', 'book' => 'Melalui Sekretaris Direksi', 'image' => '/images/facilities-office.jpg'],
                    ['code' => 'EXEC-01', 'name' => 'Exec. Dir. A (Executive Director)', 'label' => 'Exec. Dir. A', 'icon' => '👤', 'group' => 'Ruang Direksi', 'color' => 'bg-indigo-700 text-white border-white', 'x' => 34.2, 'y' => 31, 'cx' => 34.2, 'cy' => 31, 'capacity' => 'Ruang Eksekutif', 'facilities' => 'Meja Eksekutif, Sofa Tamu VIP, Layar Presentasi', 'usage' => 'Ruang Kerja Executive Director', 'book' => 'Melalui Sekretaris Direksi', 'image' => '/images/hero-office.jpg'],
                    ['code' => 'MO-205', 'name' => 'Private Meet Room', 'label' => 'Private Meet Room', 'icon' => '👥', 'group' => 'Ruang Rapat', 'color' => 'bg-emerald-600 text-white border-white', 'x' => 42.2, 'y' => 31, 'cx' => 42.2, 'cy' => 31, 'capacity' => '8 – 12 orang', 'facilities' => 'Meja Bundar Eksekutif, Layar Pintar 4K, Kamera (VC)', 'usage' => 'Rapat internal direksi & diskusi strategis', 'book' => 'Melalui Sistem Ruang Rapat (Outlook / Portal Web)', 'image' => '/images/meeting-room.jpg', 'facility_slug' => 'ruang-rapat-sakura'],
                    ['code' => 'EXEC-03', 'name' => 'V. President (Wakil Presiden)', 'label' => 'V. President', 'icon' => '👤', 'group' => 'Ruang Direksi', 'color' => 'bg-amber-600 text-white border-white', 'x' => 50.2, 'y' => 31, 'cx' => 50.2, 'cy' => 31, 'capacity' => 'Ruang Eksekutif', 'facilities' => 'Meja Eksekutif, Meja Diskusi, Layar VC', 'usage' => 'Ruang Kerja Wakil Presiden Direktur', 'book' => 'Akses Terbatas (Melalui Sekretaris)', 'image' => '/images/hero-office.jpg'],
                    ['code' => 'EXEC-02', 'name' => 'Ruang Presdir (Presiden Direktur)', 'label' => 'Presdir', 'icon' => '👤', 'group' => 'Ruang Direksi', 'color' => 'bg-orange-600 text-white border-white', 'x' => 58.5, 'y' => 31, 'cx' => 58.5, 'cy' => 31, 'capacity' => 'Ruang Eksekutif', 'facilities' => 'Meja Rapat Privat, Konferensi Video, Akses Sekretaris', 'usage' => 'Ruang Kerja Presiden Direktur', 'book' => 'Akses Terbatas (Melalui Sekretaris)', 'image' => '/images/hero-office.jpg'],
                    ['code' => 'MR-03U', 'name' => 'Meeting Room 3 (Lounge Direksi)', 'label' => 'Meeting 3 (Utara)', 'icon' => '🛋️', 'group' => 'Ruang Rapat', 'color' => 'bg-amber-600 text-white border-white', 'x' => 65.8, 'y' => 31, 'cx' => 65.8, 'cy' => 31, 'capacity' => '6 – 8 orang', 'facilities' => 'Sofa Eksekutif, Meja Diskusi Santai', 'usage' => 'Ruang tunggu & briefing VIP Direksi', 'book' => 'Melalui Sekretaris Direksi', 'image' => '/images/management-office.jpg'],
                    ['code' => 'MR-07', 'name' => 'Meeting Room 7 (Area Kolaborasi)', 'label' => 'Meeting 7', 'icon' => '👥', 'group' => 'Ruang Rapat', 'color' => 'bg-rose-600 text-white border-white', 'x' => 73.8, 'y' => 31, 'cx' => 73.8, 'cy' => 31, 'capacity' => '8 – 10 orang', 'facilities' => 'Layar 4K, Kamera (VC), Meja Kolaborasi', 'usage' => 'Rapat tim, koordinasi proyek & presentasi', 'book' => 'Melalui Sistem Ruang Rapat (Outlook / Portal Web)', 'image' => '/images/meeting-room.jpg', 'facility_slug' => 'meeting-room-5'],
                    ['code' => 'MR-07B', 'name' => 'Meeting Room 7 (Oval Utama)', 'label' => 'Meeting 7 Oval', 'icon' => '👥', 'group' => 'Ruang Rapat', 'color' => 'bg-rose-600 text-white border-white', 'x' => 80.5, 'y' => 31, 'cx' => 80.5, 'cy' => 31, 'capacity' => '10 – 12 orang', 'facilities' => 'Meja Oval Besar, Layar Display 4K, Konferensi Video', 'usage' => 'Rapat evaluasi departemen & koordinasi proyek', 'book' => 'Melalui Sistem Ruang Rapat (Outlook / Portal Web)', 'image' => '/images/meeting-room.jpg'],
                    ['code' => 'MR-01', 'name' => 'Meeting Room Timur (Sayap Kanan)', 'label' => 'R. Rapat Timur', 'icon' => '👥', 'group' => 'Ruang Rapat', 'color' => 'bg-[#0066dc] text-white border-white', 'x' => 89.2, 'y' => 41, 'cx' => 89.2, 'cy' => 41, 'capacity' => '10 – 12 orang', 'facilities' => 'Meja Oval, Pencahayaan Alami, Sistem AV Lengkap', 'usage' => 'Rapat koordinasi proyek & presentasi internal', 'book' => 'Melalui Sistem Ruang Rapat (Outlook / Portal Web)', 'image' => '/images/meeting-room.jpg'],
                    ['code' => 'MR-02', 'name' => 'Meeting Room 2', 'label' => 'Meeting 2', 'icon' => '👥', 'group' => 'Ruang Rapat', 'color' => 'bg-[#0066dc] text-white border-white', 'x' => 82, 'y' => 44, 'cx' => 82, 'cy' => 44, 'capacity' => '6 – 8 orang', 'facilities' => 'Meja Rapat, Layar Display, Mikrofon & Speaker', 'usage' => 'Rapat lintas departemen & diskusi proyek', 'book' => 'Melalui Sistem Ruang Rapat (Outlook / Portal Web)', 'image' => '/images/meeting-room.jpg'],
                    ['code' => 'SEC-01', 'name' => 'R. Sekretaris (Sekretariat Direksi)', 'label' => 'R. Sekretaris', 'icon' => '💼', 'group' => 'Ruang Penunjang', 'color' => 'bg-sky-700 text-white border-white', 'x' => 67, 'y' => 46, 'cx' => 67, 'cy' => 46, 'capacity' => 'Tim Sekretariat', 'facilities' => 'Meja Pelayanan Direksi, Printer, Jadwal Ruang Rapat', 'usage' => 'Koordinasi tamu VIP, jadwal Presdir & Direksi', 'book' => 'Hubungi Meja Sekretaris Direksi', 'image' => '/images/management-office.jpg'],
                    ['code' => 'MR-05', 'name' => 'Meeting Room 3 (Sayap Timur)', 'label' => 'Meeting 3', 'icon' => '👥', 'group' => 'Ruang Rapat', 'color' => 'bg-[#0066dc] text-white border-white', 'x' => 85.2, 'y' => 59, 'cx' => 85.2, 'cy' => 59, 'capacity' => '8 – 10 orang', 'facilities' => 'Layar 4K, Kamera, Mikrofon, Konferensi Video', 'usage' => 'Untuk rapat internal & konferensi video', 'book' => 'Melalui Sistem Ruang Rapat (Outlook / Portal Web)', 'image' => '/images/meeting-room.jpg', 'facility_slug' => 'meeting-room-5'],
                    ['code' => 'MR-04', 'name' => 'Meeting Room 4 (Sayap Timur)', 'label' => 'Meeting 4', 'icon' => '👥', 'group' => 'Ruang Rapat', 'color' => 'bg-rose-600 text-white border-white', 'x' => 92.2, 'y' => 59, 'cx' => 92.2, 'cy' => 59, 'capacity' => '8 – 10 orang', 'facilities' => 'Layar, Kamera, Mikrofon, Papan Tulis', 'usage' => 'Diskusi tim lintas departemen', 'book' => 'Melalui Sistem Ruang Rapat (Outlook / Portal Web)', 'image' => '/images/meeting-room.jpg', 'facility_slug' => 'meeting-room-5'],
                    ['code' => 'SUP-01', 'name' => 'R. Server (Server Room)', 'label' => 'R. Server', 'icon' => '🖧', 'group' => 'Ruang Penunjang', 'color' => 'bg-cyan-700 text-white border-white', 'x' => 67, 'y' => 62, 'cx' => 67, 'cy' => 62, 'capacity' => 'Khusus Tim IT', 'facilities' => 'Rak Server, Pendingin Presisi, Pemadam Gas Otomatis', 'usage' => 'Pusat jaringan & server (Infrastruktur IT)', 'book' => 'Akses Biometrik (Departemen IT)', 'image' => '/images/facilities-office.jpg'],
                    ['code' => 'SUP-02', 'name' => 'R. UPS (Daya Cadangan)', 'label' => 'UPS', 'icon' => '🔋', 'group' => 'Ruang Penunjang', 'color' => 'bg-indigo-700 text-white border-white', 'x' => 79, 'y' => 62, 'cx' => 79, 'cy' => 62, 'capacity' => 'Khusus GA / Teknisi', 'facilities' => 'Uninterruptible Power Supply, Bank Baterai', 'usage' => 'Distribusi daya cadangan darurat gedung', 'book' => 'Khusus Teknisi Berwenang', 'image' => '/images/plant-exterior.jpg'],
                    ['code' => 'REST-2F', 'name' => 'Toilet Karyawan & Tamu Lantai 2', 'label' => 'Toilet Lt. 2', 'icon' => '🚻', 'group' => 'Toilet', 'color' => 'bg-emerald-600 text-white border-white', 'x' => 60.5, 'y' => 59, 'cx' => 60.5, 'cy' => 59, 'capacity' => 'Pria & Wanita', 'facilities' => 'Wastafel Sensor, Pengering Tangan, Pembersih Tangan', 'usage' => 'Toilet karyawan & tamu Lantai 2', 'book' => 'Akses Terbuka', 'image' => '/images/hero-office.jpg'],
                    ['code' => 'MO-202', 'name' => 'Area Kerja Utama (Manager & Staff)', 'label' => 'Area Kerja Staff', 'icon' => '💼', 'group' => 'Area Kerja', 'color' => 'bg-[#0f2e54] text-white border-white', 'x' => 42, 'y' => 52, 'cx' => 42, 'cy' => 52, 'capacity' => '180 Meja Kerja', 'facilities' => 'Workstation Ergonomis, Dual Monitor, Port USB-C', 'usage' => 'Ruang kerja terbuka kolaboratif untuk Manager hingga Staff', 'book' => 'Meja Terdaftar (Lihat QR Tent Card)', 'image' => '/images/facilities-office.jpg', 'facility_slug' => 'open-workspace-collaboration'],
                    ['code' => 'LOUNGE-01', 'name' => 'Area Lounge & Tangga Spiral Barat', 'label' => 'Lounge & Tangga', 'icon' => '🛋️', 'group' => 'Pantry / Santai', 'color' => 'bg-teal-600 text-white border-white', 'x' => 16.5, 'y' => 46, 'cx' => 16.5, 'cy' => 46, 'capacity' => '25 – 30 orang', 'facilities' => 'Sofa Kolaborasi, Meja Diskusi, Tangga Spiral Akses', 'usage' => 'Area diskusi santai, kolaborasi informal & akses lantai', 'book' => 'Akses Terbuka untuk Karyawan', 'image' => '/images/facilities-office.jpg'],
                    ['code' => 'LOCK-02', 'name' => 'Area Pantry & Loker Barat Lt. 2', 'label' => 'Pantry & Loker', 'icon' => '☕', 'group' => 'Pantry / Santai', 'color' => 'bg-emerald-600 text-white border-white', 'x' => 10, 'y' => 58, 'cx' => 10, 'cy' => 58, 'capacity' => '20 orang', 'facilities' => 'Pantry Kecil, Mesin Kopi, Loker Karyawan', 'usage' => 'Area penyegaran & penyimpanan barang sayap barat', 'book' => 'Akses Kartu ID Karyawan', 'image' => '/images/management-office.jpg'],
                ],
                'icons' => [],
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
