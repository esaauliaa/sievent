<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\EventController;
use App\Http\Middleware\ApplyTabScopedAuth;
use App\Http\Middleware\EnsureTabAuthenticated;
use App\Models\User;
use App\Models\Ruangan;
use App\Models\Event;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

Route::middleware(ApplyTabScopedAuth::class)->group(function () {

Route::get('/', function () {
    return redirect()->route('login');
});

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
})->middleware(EnsureTabAuthenticated::class)->name('dashboard');

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
})->middleware(EnsureTabAuthenticated::class)->name('admin.dashboard');

Route::get('/penyelenggara/dashboard', function () {
    $userId = auth()->id();

    $totalEventDibuat = Event::where('is_delete', false)
                             ->where('id_user', $userId)
                             ->count();

    $eventPendingCount = Event::where('is_delete', false)
                              ->where('id_user', $userId)
                              ->where('status', 'pending')
                              ->count();

    $eventTerbaru = Event::with('ruangan')
                         ->where('is_delete', false)
                         ->where('id_user', $userId)
                         ->latest()
                         ->take(3)
                         ->get();

    $jadwalEventSaya = Event::with('ruangan')
                            ->where('is_delete', false)
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
})->middleware(EnsureTabAuthenticated::class)->name('penyelenggara.dashboard');

Route::get('/mahasiswa/dashboard', [EventController::class, 'dashboardMahasiswa'])
    ->middleware(EnsureTabAuthenticated::class)
    ->name('mahasiswa.dashboard');

Route::middleware(EnsureTabAuthenticated::class)->group(function () {
    
    Route::get('/get-ruangan-by-tanggal', [EventController::class, 'getRuanganByTanggal'])->name('event.getRuanganByTanggal');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/presensi', [EventController::class, 'presensiIndex'])->name('presensi.index');
    Route::get('/presensi-download', [EventController::class, 'downloadSemuaPresensi'])->name('presensi.downloadAll');
    Route::get('/presensi/{id_event}/download', [EventController::class, 'downloadPresensi'])->name('presensi.download');
    Route::get('/presensi/{id_event}', [EventController::class, 'presensiShow'])->name('presensi.show');
    Route::patch('/presensi/{id_event}/{id_peserta}', [EventController::class, 'updatePresensi'])->name('presensi.update');
    Route::get('/mahasiswa/presensi', [EventController::class, 'presensiMahasiswa'])->name('mahasiswa.presensi');

    Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');
    Route::get('/ruangan/create', [RuanganController::class, 'create'])->name('ruangan.create');
    Route::post('/ruangan', [RuanganController::class, 'store'])->name('ruangan.store');
    Route::get('/ruangan/{id_ruangan}/edit', [RuanganController::class, 'edit'])->name('ruangan.edit');
    Route::put('/ruangan/{id_ruangan}', [RuanganController::class, 'update'])->name('ruangan.update');
    Route::delete('/ruangan/{id_ruangan}', [RuanganController::class, 'destroy'])->name('ruangan.destroy');

    Route::get('/event', [EventController::class, 'index'])->name('event.index');
    Route::get('/event/create', [EventController::class, 'create'])->name('event.create');
    Route::post('/event', [EventController::class, 'store'])->name('event.store'); 
    Route::get('/event/{id_event}/edit', [EventController::class, 'edit'])->name('event.edit');
    Route::put('/event/{id_event}', [EventController::class, 'update'])->name('event.update');
    Route::delete('/event/{id_event}', [EventController::class, 'destroy'])->name('event.destroy');
    Route::get('/event/{id_event}', [EventController::class, 'show'])->name('event.show');
    
    Route::post('/event/{id_event}/daftar', [EventController::class, 'daftar'])->name('event.daftar');

    Route::post('/event/{id_event}/konfirmasi', [EventController::class, 'konfirmasi'])->name('event.konfirmasi');
    Route::post('/event/{id_event}/tolak', [EventController::class, 'tolak'])->name('event.tolak');
});

require __DIR__.'/auth.php';

});
