<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('ruangan')->where('is_delete', false)->latest()->get();

        return view('event.index', compact('events'));
    }

    public function create()
    {
        $ruangans = Ruangan::where('is_delete', false)
            ->where('status_ruangan', 'tersedia')
            ->get();

        return view('event.create', compact('ruangans'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_event'          => 'required|string|max:255',
        'id_ruangan'          => 'required',
        'tanggal_pelaksanaan' => 'required|date',
        'waktu_mulai'         => 'required',
        'waktu_selesai'       => 'required',
        'kuota'               => 'required|numeric',
        'deskripsi'           => 'nullable|string',
        'poster'              => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',  // Maksimal 5MB
        'proposal'            => 'nullable|mimes:pdf|max:20480',                     // Maksimal 20MB
    ], [
        'poster.max'      => 'Ukuran file poster terlalu besar! Maksimal kapasitas adalah 5 MB.',
        'poster.image'    => 'Berkas poster harus berupa gambar.',
        'proposal.max'    => 'Ukuran file proposal terlalu besar! Maksimal kapasitas adalah 20 MB.',
        'proposal.mimes'  => 'Berkas proposal pendukung wajib berformat PDF.',
    ]);

    $data = $request->except(['poster', 'proposal']);

    if ($request->hasFile('poster')) {
        $data['poster'] = $request->file('poster')->store('posters', 'public');
    }

    if ($request->hasFile('proposal')) {
        $data['proposal'] = $request->file('proposal')->store('proposals', 'public');
    }

    $data['status'] = 'pending';
    $data['is_delete'] = false;
    $data['id_user'] = auth()->id(); 
    $data['tanggal_pengajuan'] = date('Y-m-d');

    \App\Models\Event::create($data);

    return redirect()->route('event.index')->with('success', 'Event berhasil diajukan! Menunggu konfirmasi admin.');
}

    public function edit($id_event)
    {
        $event = Event::findOrFail($id_event);
        $ruangans = Ruangan::where('is_delete', false)->get();
        
        return view('event.edit', compact('event', 'ruangans'));
    }

    public function update(Request $request, $id_event)
    {
        $request->validate([
            'nama_event' => 'required',
            'deskripsi' => 'required',
            'ruangan_id' => 'required',
            'tanggal_pelaksanaan' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'kuota' => 'required',
        ]);

        $event = Event::findOrFail($id_event);
        $event->update([
            'ruangan_id' => $request->ruangan_id,
            'nama_event' => $request->nama_event,
            'deskripsi' => $request->deskripsi,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'kuota' => $request->kuota,
        ]);

        return redirect()->route('event.index')->with('success', 'Data event berhasil diperbarui!');
    }

    public function destroy($id_event)
    {
        $event = Event::findOrFail($id_event);

        $event->update([
            'is_delete' => true
        ]);

        return redirect()->route('event.index')->with('success', 'Event berhasil dihapus!');
    }

    public function konfirmasi(Request $request, $id_event)
    {
        $event = Event::findOrFail($id_event);
        $event->update([
            'status' => $request->status ?? 'disetujui'
        ]);

        return redirect()->back()->with('success', 'Status pengajuan event berhasil diperbarui!');
    }

    public function tolak(Request $request, $id_event)
{
    // 1. Validasi input alasan wajib diisi
    $request->validate([
        'alasan_penolakan' => 'required|string|min:5|max:500'
    ], [
        'alasan_penolakan.required' => 'Anda wajib memberikan alasan kenapa pengajuan ini ditolak!',
        'alasan_penolakan.min'      => 'Alasan penolakan terlalu pendek (minimal 5 karakter).'
    ]);

    // 2. Cari data event
    $event = \App\Models\Event::findOrFail($id_event);

    $event->update([
        'status'         => 'ditolak',
        'alasan_penolakan' => $request->alasan_penolakan
    ]);

    return redirect()->back()->with('success', 'Pengajuan event telah ditolak dengan alasan yang dilampirkan.');
    }

    public function daftar($id_event)
    {
        $event = Event::findOrFail($id_event);
        return redirect()->back()->with('success', 'Anda berhasil mendaftar pada event ini!');
    }
    public function show($id_event)
    {
    $event = Event::findOrFail($id_event);
    return view('event.show', compact('event'));
    }
}