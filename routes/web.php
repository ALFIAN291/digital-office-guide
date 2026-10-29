<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuideController;
use Illuminate\Support\Facades\Route;

// ==========================================
// User-Facing Public Routes
// ==========================================
Route::get('/', [GuideController::class, 'index'])->name('guide.index');
Route::get('/message', [GuideController::class, 'message'])->name('guide.message');
Route::get('/facilities', [GuideController::class, 'facilities'])->name('guide.facilities');
Route::get('/facilities/{slug}', [GuideController::class, 'facilityDetail'])->name('guide.facility.detail');
Route::get('/map', [GuideController::class, 'map'])->name('guide.map');
Route::get('/dos-and-donts', [GuideController::class, 'dosAndDonts'])->name('guide.dos-and-donts');
Route::get('/office-and-plant', [GuideController::class, 'officeAndPlant'])->name('guide.office-and-plant');
Route::get('/emergency', [GuideController::class, 'emergency'])->name('guide.emergency');
Route::get('/api/search', [GuideController::class, 'search'])->name('guide.api.search');

// ==========================================
// Authentication Routes
// ==========================================
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// ==========================================
// Setup & Diagnostic Database Route (Vercel One-Click Setup)
// ==========================================
Route::get('/admin/setup-db', function () {
    $dbHost = config('database.connections.pgsql.host');
    $dbName = config('database.connections.pgsql.database');
    $dbUser = config('database.connections.pgsql.username');

    $envInfo = [
        'DB_CONNECTION' => config('database.default'),
        'PG_HOST' => $dbHost,
        'PG_DATABASE' => $dbName,
        'PG_USER' => $dbUser,
    ];

    if ($dbHost === '127.0.0.1' || empty($dbHost)) {
        return response()->view('admin.setup-db', [
            'status' => 'error',
            'title' => 'Database Belum Terhubung ke Vercel',
            'message' => 'Project Vercel belum mendeteksi environment variable dari database Neon (akebono-db).',
            'details' => "Langkah menghubungkan di Vercel Dashboard:\n1. Buka Vercel Dashboard > tab Storage (atau menu Storage).\n2. Klik database 'akebono-db' yang sudah Anda buat.\n3. Masuk ke tab 'Settings' atau cari tombol 'Connect Project'.\n4. Pilih project 'digital-office-guide' lalu klik Connect.\n5. Setelah itu, buka tab 'Deployments' di Vercel > klik titik tiga (...) di deployment paling atas > klik 'Redeploy'.",
            'envInfo' => $envInfo,
        ]);
    }

    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $migrateOutput = \Illuminate\Support\Facades\Artisan::output();

        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        $seedOutput = \Illuminate\Support\Facades\Artisan::output();

        return response()->view('admin.setup-db', [
            'status' => 'success',
            'title' => 'Database Berhasil Disetup & Diisi Data Awal!',
            'message' => 'Semua tabel panduan kantor dan akun Administrator default telah berhasil dibuat.',
            'details' => $migrateOutput . "\n" . $seedOutput,
            'envInfo' => $envInfo,
        ]);
    } catch (\Throwable $e) {
        return response()->view('admin.setup-db', [
            'status' => 'error',
            'title' => 'Koneksi ke Database Gagal',
            'message' => $e->getMessage(),
            'details' => $e->getTraceAsString(),
            'envInfo' => $envInfo,
        ]);
    }
})->name('admin.setup-db');

// ==========================================
// Admin Protected CMS Routes
// ==========================================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard.index');

    // Edit Home & Initial Screen Content ("konten yang diawal")
    Route::get('/home', [AdminController::class, 'editHome'])->name('home.edit');
    Route::post('/home', [AdminController::class, 'updateHome'])->name('home.update');

    // Edit "A Message from Management"
    Route::get('/message', [AdminController::class, 'editMessage'])->name('message.edit');
    Route::post('/message', [AdminController::class, 'updateMessage'])->name('message.update');

    // Facilities Management
    Route::get('/facilities', [AdminController::class, 'facilities'])->name('facilities.index');
    Route::get('/facilities/create', [AdminController::class, 'createFacility'])->name('facilities.create');
    Route::post('/facilities', [AdminController::class, 'storeFacility'])->name('facilities.store');
    Route::get('/facilities/{id}/edit', [AdminController::class, 'editFacility'])->name('facilities.edit');
    Route::put('/facilities/{id}', [AdminController::class, 'updateFacility'])->name('facilities.update');
    Route::delete('/facilities/{id}', [AdminController::class, 'deleteFacility'])->name('facilities.delete');

    // Dos & Don'ts Management
    Route::get('/rules', [AdminController::class, 'dosAndDonts'])->name('rules.index');
    Route::get('/rules/create', [AdminController::class, 'createRule'])->name('rules.create');
    Route::post('/rules', [AdminController::class, 'storeRule'])->name('rules.store');
    Route::get('/rules/{id}/edit', [AdminController::class, 'editRule'])->name('rules.edit');
    Route::put('/rules/{id}', [AdminController::class, 'updateRule'])->name('rules.update');
    Route::delete('/rules/{id}', [AdminController::class, 'deleteRule'])->name('rules.delete');

    // Emergency Contacts Management
    Route::get('/emergency', [AdminController::class, 'emergencyContacts'])->name('emergency.index');
    Route::put('/emergency/{id}', [AdminController::class, 'updateEmergencyContact'])->name('emergency.update');

    // Change Password
    Route::get('/password', [AdminController::class, 'editPassword'])->name('password.edit');
    Route::post('/password', [AdminController::class, 'updatePassword'])->name('password.update');
});
