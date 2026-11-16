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
Route::get('/onboarding', [GuideController::class, 'onboarding'])->name('guide.onboarding');
Route::get('/canteen', [GuideController::class, 'canteen'])->name('guide.canteen');
Route::get('/visitor-guide', [GuideController::class, 'visitorGuide'])->name('guide.visitor');
Route::get('/attendance', [GuideController::class, 'attendance'])->name('guide.attendance');
Route::get('/support', [GuideController::class, 'support'])->name('guide.support');
Route::get('/api/search', [GuideController::class, 'search'])->name('guide.api.search');
Route::get('/media/{type}/{id}/{column}', [GuideController::class, 'media'])
    ->whereNumber('id')
    ->where('column', '[a-z_]+')
    ->name('guide.media');

// ==========================================
// Authentication Routes
// ==========================================
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [AuthController::class, 'login'])->middleware('throttle:10,1')->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// ==========================================
// Admin Protected CMS Routes
// ==========================================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Database migration & reference content check (authenticated admins only)
    Route::get('/setup-db', function () {
        $dbHost = config('database.connections.pgsql.host');
        $envInfo = [
            'DB_CONNECTION' => config('database.default'),
            'STATUS' => ($dbHost && $dbHost !== '127.0.0.1') ? 'Terhubung (Remote)' : 'Lokal',
        ];

        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            $migrateOutput = \Illuminate\Support\Facades\Artisan::output();

            if (\App\Models\Facility::count() === 0) {
                \Illuminate\Support\Facades\Artisan::call('db:seed', [
                    '--class' => \Database\Seeders\DigitalOfficeGuideSeeder::class,
                    '--force' => true,
                ]);
                $seedOutput = \Illuminate\Support\Facades\Artisan::output();
            } else {
                $seedOutput = 'Database sudah aktif dan terisi data.';
            }

            return response()->view('admin.setup-db', [
                'status' => 'success',
                'title' => 'Status & Migrasi Database Berhasil',
                'message' => 'Seluruh tabel panduan kantor telah diperiksa dan siap digunakan.',
                'details' => $migrateOutput . "\n" . $seedOutput,
                'envInfo' => $envInfo,
            ]);
        } catch (\Throwable $e) {
            return response()->view('admin.setup-db', [
                'status' => 'error',
                'title' => 'Operasi Database Gagal',
                'message' => 'Gagal menjalankan pemeriksaan atau migrasi database.',
                'details' => 'Silakan periksa konfigurasi koneksi database pada environment server.',
                'envInfo' => $envInfo,
            ], 500);
        }
    })->name('setup-db');

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

    // QR Desk Onboarding & Tent Card Management
    Route::get('/desks', [AdminController::class, 'desks'])->name('desks.index');
    Route::post('/desks', [AdminController::class, 'storeDesk'])->name('desks.store');
    Route::put('/desks/{id}', [AdminController::class, 'updateDesk'])->name('desks.update');
    Route::delete('/desks/{id}', [AdminController::class, 'deleteDesk'])->name('desks.delete');
    Route::get('/desks/{id}/print', [AdminController::class, 'printDesk'])->name('desks.print');

    // Change Password
    Route::get('/password', [AdminController::class, 'editPassword'])->name('password.edit');
    Route::post('/password', [AdminController::class, 'updatePassword'])->name('password.update');
});
