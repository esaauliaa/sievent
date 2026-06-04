<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\EventController;
use App\Models\User;
use App\Models\Ruangan;
use App\Models\Event;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

// Pengalihan halaman utama ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Penengah Dashboard Utama (Membaca Role setelah Login)
Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    if ($role === 'penyelenggara') {
        return redirect()->route('penyelenggara.dashboard');
    }
    if ($role === 'mahasiswa') {
        return redirect()->route('mahasiswa.dashboard');
    }

    return redirect('/');
})->middleware(['auth'])->name('dashboard');

// ==========================================
// DASHBOARD ADMIN
// ==========================================
Route::get('/admin/dashboard', function () {
    $totalRuangan = Ruangan::where('is_delete', false)->count();
    $ruanganTersedia = Ruangan::where('is_delete', false)->where('status_ruangan', 'tersedia')->count();
    $totalUser = User::whereIn('role', ['mahasiswa', 'penyelenggara'])->count();
    $totalMahasiswa = User::where('role', 'mahasiswa')->count();
    $totalPenyelenggara = User::where('role', 'penyelenggara')->count();
    $totalEvent = Event::where('is_delete', false)->count();
    $eventPending = Event::where('is_delete', false)->where('status', 'pending')->count();
    $totalEventDisetujui = Event::where('is_delete', false)->where('status', 'disetujui')->count();
    
    $events = Event::where('is_delete', false)
                    ->where('status', 'pending')
                    ->latest()
                    ->take(5)
                    ->get();

    $eventHariIni = Event::where('is_delete', false)
                    ->where('status', 'disetujui')
                    ->whereDate('tanggal_pelaksanaan', Carbon::today())
                    ->orderBy('waktu_mulai', 'asc')
                    ->get();

    return view('admin.dashboard', compact(
        'totalRuangan', 
        'ruanganTersedia', 
        'totalUser', 
        'totalMahasiswa', 
        'totalPenyelenggara', 
        'totalEvent', 
        'eventPending', 
        'totalEventDisetujui',
        'events',
        'eventHariIni'
    ));
})->middleware(['auth'])->name('admin.dashboard');

// ==========================================
// DASHBOARD PENYELENGGARA
// ==========================================
Route::get('/penyelenggara/dashboard', function () {
    $userId = auth()->id();

    $totalEventDibuat = Event::where('is_delete', false)
                             ->where('id_user', $userId)
                             ->count();

    $eventPendingCount = Event::where('is_delete', false)
                              ->where('id_user', $userId)
                              ->where('status', 'pending')
                              ->count();

    $eventTerbaru = Event::where('is_delete', false)
                         ->where('id_user', $userId)
                         ->latest()
                         ->take(3)
                         ->get();

    $jadwalEventSaya = Event::where('is_delete', false)
                            ->where('id_user', $userId)
                            ->where('status', 'disetujui')
                            ->whereDate('tanggal_pelaksanaan', '>=', Carbon::today())
                            ->orderBy('tanggal_pelaksanaan', 'asc')
                            ->orderBy('waktu_mulai', 'asc')
                            ->get();

    return view('penyelenggara.dashboard', compact(
        'totalEventDibuat',
        'eventPendingCount',
        'eventTerbaru',
        'jadwalEventSaya'
    ));
})->middleware(['auth'])->name('penyelenggara.dashboard');

// ==========================================
// DASHBOARD MAHASISWA (SUDAH DISINKRONKAN)
// ==========================================
Route::get('/mahasiswa/dashboard', [EventController::class, 'dashboardMahasiswa'])
    ->middleware(['auth'])
    ->name('mahasiswa.dashboard');

// ==========================================
// PROTECTED ROUTES (GRUP MITRA AUTH)
// ==========================================
Route::middleware('auth')->group(function () {
    
    Route::get('/get-ruangan-by-tanggal', [EventController::class, 'getRuanganByTanggal'])->name('event.getRuanganByTanggal');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ruangan Management
    Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');
    Route::get('/ruangan/create', [RuanganController::class, 'create'])->name('ruangan.create');
    Route::post('/ruangan', [RuanganController::class, 'store'])->name('ruangan.store');
    Route::get('/ruangan/{id_ruangan}/edit', [RuanganController::class, 'edit'])->name('ruangan.edit');
    Route::put('/ruangan/{id_ruangan}', [RuanganController::class, 'update'])->name('ruangan.update');
    Route::delete('/ruangan/{id_ruangan}', [RuanganController::class, 'destroy'])->name('ruangan.destroy');

    // Event Management
    Route::get('/event', [EventController::class, 'index'])->name('event.index');
    Route::get('/event/create', [EventController::class, 'create'])->name('event.create');
    Route::post('/event', [EventController::class, 'store'])->name('event.store'); 
    Route::get('/event/{id_event}/edit', [EventController::class, 'edit'])->name('event.edit');
    Route::put('/event/{id_event}', [EventController::class, 'update'])->name('event.update');
    Route::delete('/event/{id_event}', [EventController::class, 'destroy'])->name('event.destroy');
    Route::post('/event/{id_event}/daftar', [EventController::class, 'daftar'])->name('event.daftar');
    Route::get('/event/{id_event}', [EventController::class, 'show'])->name('event.show');

    // Verifikasi Admin
    Route::post('/event/{id_event}/konfirmasi', [EventController::class, 'konfirmasi'])->name('event.konfirmasi');
    Route::post('/event/{id_event}/tolak', [EventController::class, 'tolak'])->name('event.tolak');
});

require __DIR__.'/auth.php';