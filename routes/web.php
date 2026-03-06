<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BandaraController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\PenerbanganController;

// --- HALAMAN UTAMA (PUBLIC) ---
// Route ini sekarang bebas diakses siapa saja (Guest maupun Admin)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cari-tiket', [PenerbanganController::class, 'search'])->name('penerbangan.search');

// --- AUTH ROUTES ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::get('/save-intended-url', [AuthController::class, 'saveIntendedUrl'])->name('auth.save_url');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// --- AUTHENTICATED ROUTES ---
Route::middleware('auth')->group(function () {

    // Prefix User
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::resource('pemesanan', PemesananController::class)->only(['index', 'create', 'store']);
        Route::get('/riwayat', [PemesananController::class, 'index'])->name('riwayat');
        Route::patch('/pemesanan/{id}/upload-bukti', [PemesananController::class, 'uploadBukti'])->name('pemesanan.upload');

        // Chat User Routes
        Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
        Route::post('/chat/send', [ChatController::class, 'store'])->name('chat.store');
    });

    // Prefix Admin
    Route::middleware(['can:access-admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('penerbangan', PenerbanganController::class);
        Route::resource('bandara', BandaraController::class);
        Route::resource('pemesanan', PemesananController::class);
        Route::patch('/pemesanan/{id}/status', [PemesananController::class, 'updateStatus'])->name('pemesanan.updateStatus');

        // Chat Admin Routes
        Route::get('/chat', [ChatController::class, 'adminIndex'])->name('chat.index');
        Route::get('/chat/{id}', [ChatController::class, 'adminShow'])->name('chat.show');
    });
});

Route::get('/user/pemesanan/pdf/{id}', [PemesananController::class, 'downloadPdf'])->name('user.pemesanan.pdf');
