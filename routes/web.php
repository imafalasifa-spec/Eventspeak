<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController; // Pastikan huruf kecil/besar sesuai nama file
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PenyelenggaraController;
use App\Http\Controllers\PembicaraController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

// Halaman utama & Dashboard Pengguna
Route::get('/', [userController::class, 'index'])->name('landing');
Route::get('/pengguna/index', [userController::class, 'index'])->name('pengguna.index');

// Grouping Login
Route::get('/login', [userController::class, 'showLogin'])->name('login');
Route::post('/login', [userController::class, 'login'])->name('login.post');

// Register
Route::get('/register', [userController::class, 'showRegister'])->name('pengguna.registrasi');
Route::post('/register', [userController::class, 'register']);

// Profil & Logout
Route::get('/pengguna/profil', [userController::class, 'showProfil'])->name('pengguna.profil');
Route::get('/logout', [userController::class, 'logout'])->name('logout');

Route::get('/eksplorasi', [userController::class, 'eksplorasi'])->name('pengguna.eksplorasi');
Route::get('/schedule', [ScheduleController::class, 'index'])->name('pengguna.schedule');
Route::get('/team', [userController::class, 'showTeam'])->name('pengguna.team');
Route::put('/profil/update', [userController::class, 'update'])->name('pengguna.update');


Route::get('/schedule', [ScheduleController::class, 'schedule'])->name('pengguna.schedule');
// Detail Event
Route::get('/event/{id}', [EventController::class, 'show'])->name('event.show');

Route::get('/checkout/{id}', [userController::class, 'checkout'])
    ->name('checkout');

Route::post('/event/{id}/daftar', [userController::class, 'daftarEvent'])
    ->name('peserta.daftar');

Route::get('/tiket/{id}', [userController::class, 'showTiket'])
    ->name('tiket.show');


// ==================== REVISI BAGIAN PENYELENGGARA DI BAWAH INI ====================

Route::prefix('penyelenggara')->name('penyelenggara.')->group(function () {

    // Penyelenggara - Form Daftar
    // Kita beri alias 'pendaftaran' agar sesuai dengan sidebar profile @else kamu kemarin
    Route::get('/daftar', [PenyelenggaraController::class, 'index'])->name('index');
    Route::get('/pendaftaran', [PenyelenggaraController::class, 'index'])->name('pendaftaran'); // Tambahan alias aman
    Route::post('/daftar', [PenyelenggaraController::class, 'store'])->name('store');

    // Penyelenggara - Dashboard
    Route::get('/dashboard', [PenyelenggaraController::class, 'dashboard'])->name('dashboard');

    // Penyelenggara - Event Management (Disamakan dengan nama method di Controller)
    Route::get('/create', [PenyelenggaraController::class, 'createevent'])->name('createevent');
    Route::post('/event/store', [PenyelenggaraController::class, 'storeEvent'])->name('storeEvent');
    Route::get('/event/{id}/edit', [PenyelenggaraController::class, 'editEvent'])->name('editEvent');
    Route::put('/event/{id}/update', [PenyelenggaraController::class, 'updateEvent'])->name('updateEvent');
    Route::delete('/event/{id}/delete', [PenyelenggaraController::class, 'deleteEvent'])->name('deleteEvent');

    // Tambahkan ini:
    Route::post('/lamaran/{id}/terima', [PenyelenggaraController::class, 'terimaLamaran'])->name('terimaLamaran');
    Route::post('/lamaran/{id}/tolak', [PenyelenggaraController::class, 'tolakLamaran'])->name('tolakLamaran');

    Route::post('/event/{id}/publish', [PenyelenggaraController::class, 'publishEvent'])->name('publishEvent');

    Route::post('/tarik-saldo', [PenyelenggaraController::class, 'tarikSaldo'])->name('tarikSaldo');
    Route::get('/peserta/{id}', [PenyelenggaraController::class, 'getPeserta'])->name('getPeserta');

    Route::get(
        '/pembicara',
        [PenyelenggaraController::class, 'pembicaraTerdaftar']
    )
        ->name('pembicara');
});

// ==================== PEMBICARA ====================
Route::prefix('pembicara')->name('pembicara.')->group(function () {
    Route::get('/daftar', [PembicaraController::class, 'index'])->name('index');
    Route::post('/daftar', [PembicaraController::class, 'store'])->name('store');
    Route::get('/dashboard', [PembicaraController::class, 'dashboard'])->name('dashboard');
    Route::post('/lamar/{event_id}', [PembicaraController::class, 'lamar'])->name('lamar');
});

Route::get(
    '/penyelenggara/export-peserta/{id}',
    [PenyelenggaraController::class, 'exportPeserta']
)->name('penyelenggara.exportPeserta');
