<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RuanganController extends Controller
{
    /**
     * Mengecek apakah user boleh tambah, edit, hapus ruangan.
     * Hanya admin yang boleh.
     */
    private function isAdmin(): bool
    {
        return Auth::check() && Auth::user()->role === 'admin';
    }

    /**
     * Menampilkan daftar ruangan.
     * Admin, mahasiswa, dan penyelenggara boleh melihat.
     */
    public function index()
    {
        $ruangans = Ruangan::where('is_delete', false)
            ->orderBy('id_ruangan', 'desc')
            ->get();

        return view('ruangan.index', compact('ruangans'));
    }

    /**
     * Menampilkan form tambah ruangan.
     * Hanya admin.
     */
    public function create()
    {
        if (!$this->isAdmin()) {
            abort(403, 'Akses ditolak. Hanya admin yang dapat menambah data ruangan.');
        }

        return view('ruangan.create');
    }

    /**
     * Menyimpan data ruangan baru.
     * Hanya admin.
     */
    public function store(Request $request)
    {
        if (!$this->isAdmin()) {
            abort(403, 'Akses ditolak. Hanya admin yang dapat menambah data ruangan.');
        }

        $request->validate(
            [
                'nama_ruangan' => ['required', 'string', 'max:100'],
                'lokasi' => ['required', 'string', 'max:150'],
                'kapasitas' => ['required', 'integer', 'min:1'],
                'status_ruangan' => ['required', 'in:tersedia,tidak_tersedia'],
            ],
            [
                'nama_ruangan.required' => 'Nama ruangan wajib diisi.',
                'nama_ruangan.max' => 'Nama ruangan maksimal 100 karakter.',

                'lokasi.required' => 'Lokasi wajib diisi.',
                'lokasi.max' => 'Lokasi maksimal 150 karakter.',

                'kapasitas.required' => 'Kapasitas wajib diisi.',
                'kapasitas.integer' => 'Kapasitas harus berupa angka.',
                'kapasitas.min' => 'Kapasitas minimal 1.',

                'status_ruangan.required' => 'Status ruangan wajib dipilih.',
                'status_ruangan.in' => 'Status ruangan tidak valid.',
            ]
        );

        Ruangan::create([
            'nama_ruangan' => $request->nama_ruangan,
            'lokasi' => $request->lokasi,
            'kapasitas' => $request->kapasitas,
            'status_ruangan' => $request->status_ruangan,
            'is_delete' => false,
        ]);

        return redirect()
            ->route('ruangan.index')
            ->with('success', 'Data ruangan berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit ruangan.
     * Hanya admin.
     */
    public function edit($id_ruangan)
    {
        if (!$this->isAdmin()) {
            abort(403, 'Akses ditolak. Hanya admin yang dapat mengedit data ruangan.');
        }

        $ruangan = Ruangan::where('id_ruangan', $id_ruangan)
            ->where('is_delete', false)
            ->firstOrFail();

        return view('ruangan.edit', compact('ruangan'));
    }

    /**
     * Menyimpan perubahan data ruangan.
     * Hanya admin.
     */
    public function update(Request $request, $id_ruangan)
    {
        if (!$this->isAdmin()) {
            abort(403, 'Akses ditolak. Hanya admin yang dapat mengedit data ruangan.');
        }

        $ruangan = Ruangan::where('id_ruangan', $id_ruangan)
            ->where('is_delete', false)
            ->firstOrFail();

        $request->validate(
            [
                'nama_ruangan' => ['required', 'string', 'max:100'],
                'lokasi' => ['required', 'string', 'max:150'],
                'kapasitas' => ['required', 'integer', 'min:1'],
                'status_ruangan' => ['required', 'in:tersedia,tidak_tersedia'],
            ],
            [
                'nama_ruangan.required' => 'Nama ruangan wajib diisi.',
                'nama_ruangan.max' => 'Nama ruangan maksimal 100 karakter.',

                'lokasi.required' => 'Lokasi wajib diisi.',
                'lokasi.max' => 'Lokasi maksimal 150 karakter.',

                'kapasitas.required' => 'Kapasitas wajib diisi.',
                'kapasitas.integer' => 'Kapasitas harus berupa angka.',
                'kapasitas.min' => 'Kapasitas minimal 1.',

                'status_ruangan.required' => 'Status ruangan wajib dipilih.',
                'status_ruangan.in' => 'Status ruangan tidak valid.',
            ]
        );

        $ruangan->update([
            'nama_ruangan' => $request->nama_ruangan,
            'lokasi' => $request->lokasi,
            'kapasitas' => $request->kapasitas,
            'status_ruangan' => $request->status_ruangan,
        ]);

        return redirect()
            ->route('ruangan.index')
            ->with('success', 'Data ruangan berhasil diperbarui.');
    }

    /**
     * Menghapus data ruangan.
     * Data tidak benar-benar dihapus, hanya is_delete menjadi true.
     * Hanya admin.
     */
    public function destroy($id_ruangan)
    {
        if (!$this->isAdmin()) {
            abort(403, 'Akses ditolak. Hanya admin yang dapat menghapus data ruangan.');
        }

        $ruangan = Ruangan::where('id_ruangan', $id_ruangan)
            ->where('is_delete', false)
            ->firstOrFail();

        $ruangan->update([
            'is_delete' => true,
        ]);

        return redirect()
            ->route('ruangan.index')
            ->with('success', 'Data ruangan berhasil dihapus.');
    }
}
