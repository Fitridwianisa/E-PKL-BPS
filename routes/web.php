<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PendaftarController;
use App\Http\Controllers\SertifikatController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\SuratBalasanController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Auth (Login, Register, Logout)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/profile', [AuthController::class, 'profile'])->name('profile.index');
// web.php
Route::put('/profile/update', [AuthController::class, 'update'])->name('profile.update');


Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Pendaftar Routes (Hanya untuk user yang login dan rolenya 'user')
Route::middleware(['auth'])->group(function () {
    Route::group(['middleware' => function ($request, $next) {
        if (auth()->user()->role !== 'peserta') {
            return redirect(url()->previous());
        }
        return $next($request);
    }], function () {
        // Dashboard Pendaftar
        Route::get('/pendaftar/dashboard', [PendaftarController::class, 'dashboard'])->name('pendaftar.dashboard');

        Route::get('/pendaftar/form_pendaftaran', [PendaftarController::class, 'formPendaftaran'])->name('pendaftar.form_pendaftaran');

        Route::post('/pendaftaran/store-biodata', [PendaftarController::class, 'storeBiodata'])->name('pendaftaran.store.biodata');
        Route::post('/pendaftaran/store-pendaftaran', [PendaftarController::class, 'storePendaftaran'])->name('pendaftaran.store.pendaftaran');

        Route::get('/pendaftar/sertifikat', [SertifikatController::class, 'sertifikat'])->name('pendaftar.sertifikat');
        Route::get('/sertifikat/download', [SertifikatController::class, 'download'])->name('sertifikat.download');
        Route::get('/sertifikat/preview', [SertifikatController::class, 'preview'])->name('sertifikat.preview');
    });
});

// Admin Routes (Hanya untuk user yang login dan rolenya 'admin')
Route::middleware(['auth'])->group(function () {
    Route::group(['middleware' => function ($request, $next) {
        if (auth()->user()->role !== 'admin') {
            return redirect(url()->previous());
        }
        return $next($request);
    }], function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/pendaftaran', [AdminController::class, 'pendaftaran'])->name('admin.pendaftaran');
        Route::get('/admin/peserta', [AdminController::class, 'peserta'])->name('admin.peserta');
        Route::get('/admin/artikel', [AdminController::class, 'artikel'])->name('admin.artikel');

        Route::get('/admin/pendaftaran/{id}', [AdminController::class, 'showPendaftaran'])->name('admin.pendaftaran.show');
        Route::put('/admin/pendaftaran/{id}/konfirmasi', [AdminController::class, 'konfirmasi'])->name('admin.pendaftaran.konfirmasi');

        Route::post('/admin/surat-balasan', [SuratBalasanController::class, 'store'])->name('admin.suratbalasan.store');
        Route::put('/admin/pendaftaran/{id}/konfirmasi', [AdminController::class, 'konfirmasi'])->name('admin.pendaftaran.konfirmasi');

        Route::post('/artikel/store', [AdminController::class, 'store'])->name('artikel.store');
        Route::get('/artikel/{id}/edit', [AdminController::class, 'edit'])->name('artikel.edit');
        Route::delete('/artikel/{id}', [AdminController::class, 'destroy'])->name('artikel.destroy');
        Route::get('/artikel/{id}/update', action: [AdminController::class, 'update'])->name('artikel.update');
        Route::put('/artikel/{id}/update', [AdminController::class, 'update'])->name('artikel.update');

        Route::get('/admin/pendaftaran/{id}/peserta', [AdminController::class, 'showPeserta'])->name('admin.pendaftaran.showpeserta');

        Route::get('/admin/pengguna', [AuthController::class, 'index'])->name('admin.pengguna');
        Route::post('/admin/pengguna', [AuthController::class, 'store'])->name('admin.pengguna.store');
    });
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::post('/sertifikat/upload/{user}', [SertifikatController::class, 'upload'])->name('admin.upload_sertifikat');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/sertifikat/preview-auto/{user}', [SertifikatController::class, 'previewAuto'])
        ->name('admin.sertifikat.preview.auto');

    Route::get('/sertifikat/download-auto/{user}', [SertifikatController::class, 'downloadAuto'])
        ->name('admin.sertifikat.download.auto');
});


// Umum (bisa diakses siapa saja)
Route::get('/artikel/{id}/index', action: [ArtikelController::class, 'ShowArtikel'])->name('artikel.index');
