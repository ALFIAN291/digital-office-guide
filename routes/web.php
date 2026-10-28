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
