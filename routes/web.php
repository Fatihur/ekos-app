<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\PemilikKos\DashboardController as PemilikDashboardController;
use App\Http\Controllers\PencariKos\HomeController;
use App\Http\Controllers\Admin\ManajemenPemesananController;
use App\Http\Controllers\PencariKos\ProfilController;
use App\Http\Controllers\PencariKos\UlasanController;
use App\Http\Controllers\NotifikasiController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/pencarian', [HomeController::class, 'pencarian'])->name('pencarian');
Route::get('/kos/{id}', [App\Http\Controllers\PencariKos\DetailKosController::class, 'show'])->name('kos.detail');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    // Forgot Password Routes
    Route::get('/lupa-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/lupa-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Email Verification Routes
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [VerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
        ->middleware('signed')->name('verification.verify');
    Route::post('/email/resend', [VerificationController::class, 'resend'])
        ->middleware('throttle:6,1')->name('verification.resend');
});

// Notifikasi Routes (untuk semua user yang login)
Route::middleware('auth')->prefix('notifikasi')->name('notifikasi.')->group(function () {
    Route::get('/', [NotifikasiController::class, 'index'])->name('index');
    Route::post('/{id}/read', [NotifikasiController::class, 'markAsRead'])->name('read');
    Route::post('/read-all', [NotifikasiController::class, 'markAllAsRead'])->name('read-all');
    Route::get('/unread-count', [NotifikasiController::class, 'getUnreadCount'])->name('unread-count');
});

// Admin Routes
Route::middleware(['auth', 'verified', App\Http\Middleware\RoleMiddleware::class.':admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Manajemen Pengguna
    Route::resource('pengguna', App\Http\Controllers\Admin\ManajemenPenggunaController::class);
    
    // Manajemen Kos
    Route::get('/kos', [App\Http\Controllers\Admin\ManajemenKosController::class, 'index'])->name('kos.index');
    Route::get('/kos/{id}', [App\Http\Controllers\Admin\ManajemenKosController::class, 'show'])->name('kos.show');
    Route::post('/kos/{id}/toggle-aktif', [App\Http\Controllers\Admin\ManajemenKosController::class, 'toggleAktif'])->name('kos.toggle-aktif');
    
    // Manajemen Pemesanan
    Route::get('/pemesanan', [ManajemenPemesananController::class, 'index'])->name('pemesanan.index');
    Route::get('/pemesanan/{id}', [ManajemenPemesananController::class, 'show'])->name('pemesanan.show');
    
    // Laporan
    Route::get('/laporan', [App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporan.index');
});

// Pemilik Kos Routes
Route::middleware(['auth', 'verified', App\Http\Middleware\RoleMiddleware::class.':pemilik_kos'])->prefix('pemilik')->name('pemilik.')->group(function () {
    Route::get('/dashboard', [PemilikDashboardController::class, 'index'])->name('dashboard');
    
    // Manajemen Kos
    Route::resource('kos', App\Http\Controllers\PemilikKos\KosController::class)->parameters(['kos' => 'ko']);
    Route::delete('/kos/{koId}/foto/{fotoId}', [App\Http\Controllers\PemilikKos\KosController::class, 'deleteFoto'])->name('kos.foto.delete');
    
    // Manajemen Pemesanan
    Route::get('/pemesanan', [App\Http\Controllers\PemilikKos\PemesananController::class, 'index'])->name('pemesanan.index');
    Route::get('/pemesanan/{id}', [App\Http\Controllers\PemilikKos\PemesananController::class, 'show'])->name('pemesanan.show');
    Route::post('/pemesanan/{id}/approve', [App\Http\Controllers\PemilikKos\PemesananController::class, 'approve'])->name('pemesanan.approve');
    Route::post('/pemesanan/{id}/reject', [App\Http\Controllers\PemilikKos\PemesananController::class, 'reject'])->name('pemesanan.reject');
    Route::post('/pemesanan/{id}/verify-payment', [App\Http\Controllers\PemilikKos\PemesananController::class, 'verifyPayment'])->name('pemesanan.verify-payment');
    Route::post('/pemesanan/{id}/reject-payment', [App\Http\Controllers\PemilikKos\PemesananController::class, 'rejectPayment'])->name('pemesanan.reject-payment');
    Route::post('/pemesanan/{id}/complete', [App\Http\Controllers\PemilikKos\PemesananController::class, 'complete'])->name('pemesanan.complete');
    
    // Pengaturan
    Route::get('/pengaturan', [App\Http\Controllers\PemilikKos\PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::put('/pengaturan', [App\Http\Controllers\PemilikKos\PengaturanController::class, 'update'])->name('pengaturan.update');
});

// Pencari Kos Routes
Route::middleware(['auth', 'verified', App\Http\Middleware\RoleMiddleware::class.':pencari_kos'])->name('pencari.')->group(function () {
    // Bookmark
    Route::get('/bookmark', [App\Http\Controllers\PencariKos\BookmarkController::class, 'index'])->name('bookmark.index');
    Route::post('/bookmark/{kosId}', [App\Http\Controllers\PencariKos\BookmarkController::class, 'toggle'])->name('bookmark.toggle');
    
    // Pemesanan
    Route::get('/pemesanan', [App\Http\Controllers\PencariKos\PemesananController::class, 'index'])->name('pemesanan.index');
    Route::get('/pemesanan/{id}', [App\Http\Controllers\PencariKos\PemesananController::class, 'show'])->name('pemesanan.show');
    Route::post('/pemesanan', [App\Http\Controllers\PencariKos\PemesananController::class, 'store'])->name('pemesanan.store');
    Route::post('/pemesanan/{id}/upload-bukti', [App\Http\Controllers\PencariKos\PemesananController::class, 'uploadBuktiPembayaran'])->name('pemesanan.upload-bukti');
    Route::put('/pemesanan/{id}/cancel', [App\Http\Controllers\PencariKos\PemesananController::class, 'cancel'])->name('pemesanan.cancel');
    
    // Ulasan
    Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
    Route::put('/ulasan/{id}', [UlasanController::class, 'update'])->name('ulasan.update');
    Route::delete('/ulasan/{id}', [UlasanController::class, 'destroy'])->name('ulasan.destroy');
    
    // Profil
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
});
