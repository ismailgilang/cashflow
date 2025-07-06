<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\KodeController;
use App\Http\Controllers\admin\LaporanController;
use App\Http\Controllers\admin\PemasukanController;
use App\Http\Controllers\admin\PengeluaranController;
use App\Http\Controllers\admin\RiwayatController;
use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\super\SuperController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.index');
    Route::resource('Pengeluaran', PengeluaranController::class);
    Route::resource('Pemasukan', PemasukanController::class);
    Route::resource('Kode', KodeController::class);
    Route::resource('Users', UsersController::class);
    Route::resource('Laporan', LaporanController::class);
    Route::resource('Riwayat', RiwayatController::class);
});

// Untuk user biasa
Route::middleware(['auth'])->prefix('super')->group(function () {
    Route::get('/dashboard', [SuperController::class, 'index'])->name('dashboard');
    Route::resource('Riwayat', RiwayatController::class);
});

Route::middleware(['auth'])->prefix('manajer')->group(function () {
    Route::get('/dashboard', [ManagerController::class, 'index'])->name('manajer.index');
    Route::get('/pengeluaran', [ManagerController::class, 'create'])->name('manager.create');
    Route::get('/pemasukan', [ManagerController::class, 'create2'])->name('manager.create2');
    Route::get('/edit/{id}', [ManagerController::class, 'edit'])->name('manager.edit');
    Route::get('/edit2/{id}', [ManagerController::class, 'edit2'])->name('manager.edit2');
    Route::get('/edit21/{id}', [ManagerController::class, 'edit21'])->name('manager.edit21');
    Route::get('/edit22/{id}', [ManagerController::class, 'edit22'])->name('manager.edit22');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
