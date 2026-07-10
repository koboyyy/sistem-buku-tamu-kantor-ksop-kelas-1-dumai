<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\AdminController;

// =============================================
// AUTH ROUTES
// =============================================

Route::get('/', fn() => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

// LOGIN GABUNGAN
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

// REGISTER HANYA TAMU
Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


// =============================================
// TAMU ROUTES (guard: tamu)
// =============================================

Route::middleware('auth:tamu')
    ->prefix('tamu')
    ->name('tamu.')
    ->group(function () {

        Route::get('/dashboard', [TamuController::class, 'dashboard'])
            ->name('dashboard');

        // Input kunjungan
        Route::get('/kunjungan/buat', [TamuController::class, 'formKunjungan'])
            ->name('kunjungan.form');

        Route::post('/kunjungan/simpan', [TamuController::class, 'simpanKunjungan'])
            ->name('kunjungan.simpan');

        // Nomor antrian
        Route::get('/antrian/{id}', [TamuController::class, 'antrian'])
            ->name('antrian');

        Route::get('/antrian/{id}/realtime', [TamuController::class, 'realtimeAntrian'])
            ->name('antrian.realtime');

        Route::get('/antrian/{id}/sebelum', [TamuController::class, 'antrianSebelum'])
            ->name('antrian.sebelum');

        // Riwayat
        Route::get('/riwayat', [TamuController::class, 'riwayat'])
            ->name('riwayat');

        Route::post('/kunjungan/{id}/selesai', [TamuController::class, 'selesai'])
            ->name('kunjungan.selesai');

        // Monitor antrian
        Route::get(
            '/monitor-antrian',
            [TamuController::class, 'monitorAntrian']
        )->name('monitor.antrian');

        // =============================================
        // PROFIL TAMU
        // =============================================
    
        // Halaman profil
        Route::get(
            '/profil',
            [TamuController::class, 'profil']
        )->name('profil');

        // Update profil
        Route::put(
            '/profil/update',
            [TamuController::class, 'updateProfil']
        )->name('profil.update');

    });


// =============================================
// ADMIN ROUTES (guard: admin)
// =============================================

Route::middleware('auth:admin')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        // Kelola tamu
        Route::get('/tamu', [AdminController::class, 'daftarTamu'])
            ->name('tamu.index');

        Route::get('/tamu/{id}/riwayat', [AdminController::class, 'riwayatTamu'])->name('tamu.riwayat');

        Route::delete('/tamu/{id}', [AdminController::class, 'hapusTamu'])
            ->name('tamu.hapus');

        // Kelola kunjungan
        Route::get('/kunjungan', [AdminController::class, 'daftarKunjungan'])
            ->name('kunjungan.index');

        Route::get('/kunjungan/{id}', [AdminController::class, 'detailKunjungan'])
            ->name('kunjungan.detail');

        Route::post('/kunjungan/{id}/status', [AdminController::class, 'ubahStatus'])
            ->name('kunjungan.status');

        Route::delete('/kunjungan/{id}', [AdminController::class, 'hapusKunjungan'])
            ->name('kunjungan.hapus');

        // Laporan
        Route::get('/laporan', [AdminController::class, 'laporan'])
            ->name('laporan');

        Route::post(
            '/kunjungan/{id}/selesai',
            [AdminController::class, 'selesai']
        )->name('kunjungan.selesai');

        Route::get(
            '/admin/profil',
            [AdminController::class, 'profil']
        )->name('profil');

        Route::put(
            '/admin/profil/update',
            [AdminController::class, 'updateProfil']
        )->name('profil.update');
    });