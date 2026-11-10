<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/admin', [DashboardController::class, 'admin'])->name('admin');
Route::post('/insiden', [DashboardController::class, 'store'])->name('incidents.store');
Route::post('/kesesuaian-iklim', [DashboardController::class, 'storeClimateSuitability'])->name('climate-suitability.store');
Route::post('/malaria-observasi', [DashboardController::class, 'storeMalariaObservation'])->name('malaria-observations.store');
Route::post('/pengaturan/template-whatsapp', [DashboardController::class, 'saveWhatsappTemplate'])->name('whatsapp-template.save');
Route::post('/penerima-whatsapp', [DashboardController::class, 'storeWhatsappRecipient'])->name('whatsapp-recipients.store');
Route::delete('/penerima-whatsapp/{recipient}', [DashboardController::class, 'destroyWhatsappRecipient'])->name('whatsapp-recipients.destroy');
Route::delete('/insiden/{incident}', [DashboardController::class, 'destroy'])->name('incidents.destroy');
