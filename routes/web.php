<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\PasienController;
use App\Http\Controllers\Admin\DokterController;
use App\Http\Controllers\Admin\PoliklinikController;
use App\Http\Controllers\Admin\KamarController;
use App\Http\Controllers\Admin\ObatController;
use App\Http\Controllers\Dokter\RawatJalanController;
use App\Http\Controllers\Dokter\RawatInapController;
use App\Http\Controllers\Dokter\ResepController;
use App\Http\Controllers\Kasir\BillingController;
use App\Http\Controllers\Farmasi\ResepFarmasiController;
use App\Http\Controllers\Laboratorium\PemeriksaanLabController;
use App\Http\Controllers\Radiologi\PemeriksaanRadiologiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard route yang akan redirect berdasarkan role
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Dashboard untuk setiap role
Route::middleware(['auth', 'verified'])->group(function () {
    // Admin Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])
        ->middleware('role:admin')
        ->name('admin.dashboard');

    // Dokter Dashboard
    Route::get('/dokter/dashboard', [DashboardController::class, 'dokterDashboard'])
        ->middleware('role:dokter')
        ->name('dokter.dashboard');

    // Perawat Dashboard
    Route::get('/perawat/dashboard', [DashboardController::class, 'perawatDashboard'])
        ->middleware('role:perawat')
        ->name('perawat.dashboard');

    // Kasir Dashboard
    Route::get('/kasir/dashboard', [DashboardController::class, 'kasirDashboard'])
        ->middleware('role:kasir')
        ->name('kasir.dashboard');

    // Farmasi Dashboard
    Route::get('/farmasi/dashboard', [DashboardController::class, 'farmasiDashboard'])
        ->middleware('role:farmasi')
        ->name('farmasi.dashboard');

    // Laboratorium Dashboard
    Route::get('/laboratorium/dashboard', [DashboardController::class, 'laboratoriumDashboard'])
        ->middleware('role:laboratorium')
        ->name('laboratorium.dashboard');

    // Radiologi Dashboard
    Route::get('/radiologi/dashboard', [DashboardController::class, 'radiologiDashboard'])
        ->middleware('role:radiologi')
        ->name('radiologi.dashboard');
});

// Admin Routes
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('pasien', PasienController::class);
    Route::resource('dokter', DokterController::class);
    Route::resource('poliklinik', PoliklinikController::class);
    Route::resource('kamar', KamarController::class);
    Route::resource('obat', ObatController::class);
});

// Dokter Routes
Route::middleware(['auth', 'verified', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::resource('rawat-jalan', RawatJalanController::class);
    Route::resource('rawat-inap', RawatInapController::class);
    Route::resource('resep', ResepController::class);
});

// Kasir Routes
Route::middleware(['auth', 'verified', 'role:kasir'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::resource('billing', BillingController::class);
});

// Farmasi Routes
Route::middleware(['auth', 'verified', 'role:farmasi'])->prefix('farmasi')->name('farmasi.')->group(function () {
    Route::resource('resep', ResepFarmasiController::class);
});

// Laboratorium Routes
Route::middleware(['auth', 'verified', 'role:laboratorium'])->prefix('laboratorium')->name('laboratorium.')->group(function () {
    Route::resource('pemeriksaan-lab', PemeriksaanLabController::class);
});

// Radiologi Routes
Route::middleware(['auth', 'verified', 'role:radiologi'])->prefix('radiologi')->name('radiologi.')->group(function () {
    Route::resource('pemeriksaan-radiologi', PemeriksaanRadiologiController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
