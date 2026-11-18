<?php

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

// Panel pengelola sementara dapat dibuka tanpa login.
Route::get('/login', fn () => redirect()->route('admin'))->name('login');
Route::get('/admin', [DashboardController::class, 'admin'])->name('admin');

// Manajemen Operasional & WhatsApp
Route::post('/insiden', [DashboardController::class, 'store'])->name('incidents.store');
Route::delete('/insiden/{incident}', [DashboardController::class, 'destroy'])->name('incidents.destroy');
Route::post('/kesesuaian-iklim', [DashboardController::class, 'storeClimateSuitability'])->name('climate-suitability.store');
Route::post('/malaria-observasi', [DashboardController::class, 'storeMalariaObservation'])->name('malaria-observations.store');
Route::post('/pengaturan/template-whatsapp', [DashboardController::class, 'saveWhatsappTemplate'])->name('whatsapp-template.save');
Route::post('/penerima-whatsapp', [DashboardController::class, 'storeWhatsappRecipient'])->name('whatsapp-recipients.store');
Route::delete('/penerima-whatsapp/{recipient}', [DashboardController::class, 'destroyWhatsappRecipient'])->name('whatsapp-recipients.destroy');

// Ribbon Tabs: Peringatan Dini, HTH, Dasarian
Route::post('/admin/peringatan-dini', [DashboardController::class, 'storeEarlyWarning'])->name('early-warning.store');
Route::delete('/admin/peringatan-dini/{earlyWarning}', [DashboardController::class, 'destroyEarlyWarning'])->name('early-warning.destroy');
Route::post('/admin/pos-hth', [DashboardController::class, 'storeHthObservation'])->name('hth-observation.store');
Route::delete('/admin/pos-hth/{hthObservation}', [DashboardController::class, 'destroyHthObservation'])->name('hth-observation.destroy');
Route::post('/admin/dasarian-gambar', [DashboardController::class, 'storeDasarianImage'])->name('dasarian-image.store');
Route::delete('/admin/dasarian-gambar/{dasarianImage}', [DashboardController::class, 'destroyDasarianImage'])->name('dasarian-image.destroy');
Route::post('/admin/buletin-iklim', [DashboardController::class, 'storeBulletin'])->name('bulletin.store');
Route::delete('/admin/buletin-iklim/{bulletin}', [DashboardController::class, 'destroyBulletin'])->name('bulletin.destroy');
