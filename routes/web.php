<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RuanganController;
use App\Models\User;
use App\Models\Ruangan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Redirect dashboard berdasarkan role user
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

// Dashboard Admin
Route::get('/admin/dashboard', function () {
    $totalRuangan = Ruangan::where('is_delete', false)->count();

    $ruanganTersedia = Ruangan::where('is_delete', false)
        ->where('status_ruangan', 'tersedia')
        ->count();

    $totalUser = User::whereIn('role', ['mahasiswa', 'penyelenggara'])->count();

    $totalMahasiswa = User::where('role', 'mahasiswa')->count();

    $totalPenyelenggara = User::where('role', 'penyelenggara')->count();

    return view('admin.dashboard', compact(
        'totalRuangan',
        'ruanganTersedia',
        'totalUser',
        'totalMahasiswa',
        'totalPenyelenggara'
    ));
})->middleware(['auth'])->name('admin.dashboard');

// Dashboard Penyelenggara
Route::get('/penyelenggara/dashboard', function () {
    return view('penyelenggara.dashboard');
})->middleware(['auth'])->name('penyelenggara.dashboard');

// Dashboard Mahasiswa
Route::get('/mahasiswa/dashboard', function () {
    return view('mahasiswa.dashboard');
})->middleware(['auth'])->name('mahasiswa.dashboard');

// Semua route yang wajib login
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ruangan
    Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');

    Route::get('/ruangan/create', [RuanganController::class, 'create'])->name('ruangan.create');
    Route::post('/ruangan', [RuanganController::class, 'store'])->name('ruangan.store');

    Route::get('/ruangan/{id_ruangan}/edit', [RuanganController::class, 'edit'])->name('ruangan.edit');
    Route::put('/ruangan/{id_ruangan}', [RuanganController::class, 'update'])->name('ruangan.update');

    Route::delete('/ruangan/{id_ruangan}', [RuanganController::class, 'destroy'])->name('ruangan.destroy');
});

require __DIR__.'/auth.php';
