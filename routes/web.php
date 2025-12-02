<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Controller untuk Warga (timeline)
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\KomentarController;

// Controller Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PengaduanController as AdminPengaduanController;

//notif
use App\Http\Controllers\NotificationController;



// -----------------------------------------------------------------------------
// HALAMAN UTAMA (WELCOME SWARGA)
// -----------------------------------------------------------------------------
Route::get('/', function () {
    return view('welcome');
})->name('welcome');


// -----------------------------------------------------------------------------
// HALAMAN TENTANG RT 01
// -----------------------------------------------------------------------------
Route::get('/tentang-rt', function () {
    return view('tentang-rt');
})->name('tentang-rt');


// -----------------------------------------------------------------------------
// DASHBOARD WARGA (TIMELINE PENGADUAN)
// -----------------------------------------------------------------------------
Route::get('/dashboard', [PengaduanController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Simpan pengaduan (seperti membuat tweet)
Route::post('/pengaduan', [PengaduanController::class, 'store'])
    ->middleware(['auth'])
    ->name('pengaduan.store');

// Simpan komentar
Route::post('/pengaduan/{pengaduan}/komentar', [KomentarController::class, 'store'])
    ->middleware(['auth'])
    ->name('komentar.store');


// -----------------------------------------------------------------------------
// PROFILE (DEFAULT BREEZE)
// -----------------------------------------------------------------------------
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
    
    // RIWAYAT PENGADUAN MILIK USER LOGIN
Route::get('/riwayat-pengaduan', [PengaduanController::class, 'riwayat'])
    ->middleware(['auth'])
    ->name('pengaduan.riwayat');

    //notif
    Route::post('/notifikasi/mark-as-read', [NotificationController::class, 'markAllAsRead'])
    ->name('notif.markAllRead');
    // RIWAYAT NOTIFIKASI (Inbox)
Route::get('/notifikasi', [NotificationController::class, 'index'])
    ->name('notif.index');

});


// -----------------------------------------------------------------------------
// ROUTE ADMIN (PAKAI ADMINLTE)
// -----------------------------------------------------------------------------
// ROUTE ADMIN (PAKAI ADMINLTE)
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // timeline admin – kalau memang mau pakai controller warga,
        // biarkan, tapi lebih rapi kalau pakai controller admin sendiri
        Route::get('/timeline', [PengaduanController::class, 'index'])
            ->name('timeline');

        Route::get('/pengaduan', [AdminPengaduanController::class, 'index'])
            ->name('pengaduan.index');

        Route::get('/pengaduan/{pengaduan}/edit', [AdminPengaduanController::class, 'edit'])
            ->name('pengaduan.edit');

        Route::put('/pengaduan/{pengaduan}', [AdminPengaduanController::class, 'update'])
            ->name('pengaduan.update');

        // 🔹 CUKUP SATU route updateStatus seperti ini
        Route::patch('/pengaduan/{pengaduan}/status', [AdminPengaduanController::class, 'updateStatus'])
            ->name('pengaduan.updateStatus');    // nama akhirnya: admin.pengaduan.updateStatus
        
            // Update Prioritas Pengaduan
        Route::patch('/admin/pengaduan/{pengaduan}/prioritas', [AdminPengaduanController::class, 'updatePrioritas'])
            ->name('pengaduan.updatePrioritas');


    });




// -----------------------------------------------------------------------------
// ROUTE AUTH BAWAAN LARAVEL BREEZE
// -----------------------------------------------------------------------------
require __DIR__.'/auth.php';
