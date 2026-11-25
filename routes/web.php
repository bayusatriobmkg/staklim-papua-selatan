<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Portal Publik
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/api/waktu-bmkg', [DashboardController::class, 'ntpTime'])->name('ntp.time');
Route::get('/profil', [DashboardController::class, 'profile'])->name('profile');
Route::get('/layanan', [DashboardController::class, 'services'])->name('services');
Route::get('/produk', [DashboardController::class, 'products'])->name('products');
Route::get('/produk/siling-malaria', [DashboardController::class, 'silingMalaria'])->name('products.malaria');
Route::get('/layanan-produk', fn() => redirect()->route('products'));
Route::get('/kontak', [DashboardController::class, 'contact'])->name('contact');

// Autentikasi Pengelola / Admin (Path Khusus Terproteksi)
Route::middleware('guest')->group(function () {
    Route::get('/adm-staklim-papsel/masuk', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/adm-staklim-papsel/masuk', [AuthController::class, 'login'])->middleware('throttle:5,1');
});

Route::post('/adm-staklim-papsel/keluar', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Panel Pengelola Data (Wajib Login)
Route::middleware('auth')->group(function () {
    Route::get('/adm-staklim-papsel', [DashboardController::class, 'admin'])->name('admin');

    // Manajemen Operasional & WhatsApp
    Route::post('/insiden', [DashboardController::class, 'store'])->name('incidents.store');
    Route::delete('/insiden/{incident}', [DashboardController::class, 'destroy'])->name('incidents.destroy');
    Route::post('/kesesuaian-iklim', [DashboardController::class, 'storeClimateSuitability'])->name('climate-suitability.store');
    Route::post('/malaria-observasi', [DashboardController::class, 'storeMalariaObservation'])->name('malaria-observations.store');
    Route::post('/pengaturan/template-whatsapp', [DashboardController::class, 'saveWhatsappTemplate'])->name('whatsapp-template.save');
    Route::post('/penerima-whatsapp', [DashboardController::class, 'storeWhatsappRecipient'])->name('whatsapp-recipients.store');
    Route::delete('/penerima-whatsapp/{recipient}', [DashboardController::class, 'destroyWhatsappRecipient'])->name('whatsapp-recipients.destroy');

    // Ribbon Tabs: Peringatan Dini, HTH, Dasarian, Buletin
    Route::post('/adm-staklim-papsel/peringatan-dini', [DashboardController::class, 'storeEarlyWarning'])->name('early-warning.store');
    Route::delete('/adm-staklim-papsel/peringatan-dini/{earlyWarning}', [DashboardController::class, 'destroyEarlyWarning'])->name('early-warning.destroy');
    Route::post('/adm-staklim-papsel/pos-hth', [DashboardController::class, 'storeHthObservation'])->name('hth-observation.store');
    Route::delete('/adm-staklim-papsel/pos-hth/{hthObservation}', [DashboardController::class, 'destroyHthObservation'])->name('hth-observation.destroy');
    Route::post('/adm-staklim-papsel/dasarian-gambar', [DashboardController::class, 'storeDasarianImage'])->name('dasarian-image.store');
    Route::delete('/adm-staklim-papsel/dasarian-gambar/{dasarianImage}', [DashboardController::class, 'destroyDasarianImage'])->name('dasarian-image.destroy');
    Route::post('/adm-staklim-papsel/buletin-iklim', [DashboardController::class, 'storeBulletin'])->name('bulletin.store');
    Route::delete('/adm-staklim-papsel/buletin-iklim/{bulletin}', [DashboardController::class, 'destroyBulletin'])->name('bulletin.destroy');
});
