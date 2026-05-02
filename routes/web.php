<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KasirController;

// ==========================
// FRONTEND
// ==========================
Route::get('/', [BerandaController::class, 'index'])->name('home');
Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');

Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/menu/{id}', [MenuController::class, 'detail'])->name('menu.detail');


// ==========================
// AUTH
// ==========================
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginProses'])->name('login.proses');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerProses'])->name('register.proses');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/lupa-password', [AuthController::class, 'lupaPassword'])->name('lupa.password');


// ==========================
// BACKEND (ADMIN)
// ==========================
Route::middleware(['auth', 'role:admin'])->prefix('backend')->group(function () {

    // DASHBOARD
    Route::get('/beranda', [BerandaController::class, 'berandaBackend'])
        ->name('backend.beranda');

    // ======================
    // MENU CRUD
    // ======================
    Route::get('/menu', [MenuController::class, 'indexBackend'])->name('backend.menu.index');
    Route::get('/menu/create', [MenuController::class, 'create'])->name('backend.menu.create');
    Route::post('/menu/store', [MenuController::class, 'store'])->name('backend.menu.store');
    Route::get('/menu/edit/{id}', [MenuController::class, 'edit'])->name('backend.menu.edit');
    Route::post('/menu/update/{id}', [MenuController::class, 'update'])->name('backend.menu.update');
    Route::get('/menu/delete/{id}', [MenuController::class, 'delete'])->name('backend.menu.delete');

    // ======================
    // TRANSAKSI (ADMIN)
    // ======================
    Route::get('/transaksi', [KasirController::class, 'riwayat'])
        ->name('backend.transaksi.index');

    Route::get('/transaksi/{id}', [KasirController::class, 'detail'])
        ->name('backend.transaksi.detail');

    // EXPORT PDF
    Route::get('/transaksi/pdf/{id}', [KasirController::class, 'cetak'])
        ->name('backend.transaksi.pdf');
    
    Route::get('/laporan', [KasirController::class, 'laporan'])
    ->name('backend.laporan');

});


// ==========================
// KASIR
// ==========================
Route::middleware(['auth', 'role:kasir'])->prefix('kasir')->group(function () {

    // HALAMAN KASIR
    Route::get('/', [KasirController::class, 'index'])->name('kasir.index');

    // SIMPAN TRANSAKSI
    Route::post('/transaksi', [KasirController::class, 'simpanTransaksi'])
        ->name('kasir.transaksi');

    // (OPTIONAL) KASIR LIHAT RIWAYAT SENDIRI
    Route::get('/riwayat', [KasirController::class, 'riwayat'])
        ->name('kasir.riwayat');

    Route::get('/detail/{id}', [KasirController::class, 'detail'])
        ->name('kasir.detail');

});