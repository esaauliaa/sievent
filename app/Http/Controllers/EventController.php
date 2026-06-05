<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ruangan;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EventController extends Controller
{
    public function dashboardMahasiswa()
    {
        $user = Auth::user();
        $userId = $user->id_user ?? $user->id;
        $eventsAktif = Event::with('ruangan')
            ->where('is_delete', false)
            ->where('status', 'disetujui')
            ->latest()
            ->take(4)
            ->get();

        $totalEventTersedia = Event::where('is_delete', false)
            ->where('status', 'disetujui')
            ->count();

        $eventsDiikutiCount = \DB::table('peserta_events')->where('id_user', $userId)->count();
        $myEventIds = \DB::table('peserta_events')->where('id_user', $userId)->pluck('id_event');
        $myEvents = Event::with('ruangan')
            ->whereIn('id_event', $myEventIds)
            ->where('is_delete', false)
            ->get();

        return view('mahasiswa.dashboard', compact(
            'eventsAktif', 
            'totalEventTersedia', 
            'eventsDiikutiCount', 
            'myEvents'
        ));
    }

    public function index()
    {
        $user = Auth::user();
        $userId = $user->id_user ?? $user->id;

        if ($user->role === 'mahasiswa') {
            $events = Event::with('ruangan')
                ->where('is_delete', false)
                ->where('status', 'disetujui')
                ->latest()
                ->get();
        } elseif ($user->role === 'penyelenggara') {
            $events = Event::with('ruangan')
                ->where('is_delete', false)
                ->where('id_user', $userId) 
                ->latest()
                ->get();
        } else {
            $events = Event::with('ruangan')->where('is_delete', false)->latest()->get();
        }

        return view('event.index', compact('events'));
    }

    public function create()
    {
        $user = Auth::user();
        $userId = $user->id_user ?? $user->id;

        $events = Event::with('ruangan')
            ->where('is_delete', false)
            ->where('id_user', $userId)
            ->latest()
            ->get();

        return view('event.create', compact('events'));
    }

    public function store(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'nama_event'          => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'id_ruangan'          => 'required',
            'waktu_mulai'         => 'required',
            'waktu_selesai'       => 'required',
            'kuota'               => 'required|numeric|min:1',
            'deskripsi'           => 'nullable|string',
            'poster'              => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'proposal'            => 'required|mimes:pdf|max:20480',
        ], [
            'nama_event.required'          => 'Nama event wajib diisi, tidak boleh kosong!',
            'tanggal_pelaksanaan.required' => 'Tanggal pelaksanaan tidak boleh kosong! Anda wajib memilih tanggal dulu.',
            'id_ruangan.required'          => 'Silakan pilih ruangan yang tersedia pada tanggal tersebut!',
            'waktu_mulai.required'         => 'Waktu mulai acara wajib diisi!',
            'waktu_selesai.required'       => 'Waktu selesai acara wajib diisi!',
            'kuota.required'               => 'Jumlah peserta wajib ditentukan, tidak boleh kosong!',
            'kuota.numeric'                => 'Jumlah peserta harus diisi menggunakan angka!',
            'poster.required'              => 'Anda wajib mengunggah poster kegiatan!',
            'poster.image'                 => 'Berkas poster harus berupa gambar (JPG, PNG, WEBP)!',
            'proposal.required'            => 'Anda wajib mengunggah berkas proposal PDF perizinan!',
            'proposal.mimes'               => 'Berkas proposal pendukung harus berformat PDF!',
        ]);

        if ($validator->fails()) {
            return redirect()->route('event.create')
                ->withErrors($validator)
                ->withInput();
        }

        $ruangan = Ruangan::where('id_ruangan', $request->id_ruangan)->firstOrFail();
        if ($request->kuota > $ruangan->kapasitas) {
            return redirect()->route('event.create')
                ->withInput()
                ->with('error', "Gagal Mengajukan! Jumlah peserta ({$request->kuota} orang) melebihi kapasitas maksimal yang ditampung oleh {$ruangan->nama_ruangan} (Maks: {$ruangan->kapasitas} orang).");
        }

        $isBentrok = Event::where('id_ruangan', $request->id_ruangan)
            ->where('is_delete', false)
            ->where('status', 'disetujui')
            ->where('tanggal_pelaksanaan', $request->tanggal_pelaksanaan)
            ->where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('waktu_mulai', '<=', $request->waktu_mulai)
                      ->where('waktu_selesai', '>', $request->waktu_mulai);
                })->orWhere(function ($q) use ($request) {
                    $q->where('waktu_mulai', '<', $request->waktu_selesai)
                      ->where('waktu_selesai', '>=', $request->waktu_selesai);
                })->orWhere(function ($q) use ($request) {
                    $q->where('waktu_mulai', '>=', $request->waktu_mulai)
                      ->where('waktu_selesai', '<=', $request->waktu_selesai);
                });
            })->exists();

        if ($isBentrok) {
            return redirect()->route('event.create')
                ->withInput()
                ->with('error', "Maaf, ruangan {$ruangan->nama_ruangan} sudah dipesan/disetujui oleh kegiatan lain pada rentang waktu tersebut. Silakan pilih jam atau ruangan lainnya!");
        }

        $data = $request->except(['poster', 'proposal']);
        if ($request->hasFile('poster')) {
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }
        if ($request->hasFile('proposal')) {
            $data['proposal'] = $request->file('proposal')->store('proposals', 'public');
        }

        $user = Auth::user();
        $data['status'] = 'pending';
        $data['is_delete'] = false;
        $data['id_user'] = $user->id_user ?? $user->id; 
        $data['tanggal_pengajuan'] = date('Y-m-d');

        Event::create($data);

        return redirect()->route('event.index')->with('success', 'Event berhasil diajukan! Menunggu konfirmasi admin.');
    }

    public function show($id_event)
    {
        $event = Event::with('ruangan')->where('id_event', $id_event)->firstOrFail();
        return view('event.show', compact('event'));
    }

    public function konfirmasi($id_event)
    {
        $event = Event::where('id_event', $id_event)->firstOrFail();
        
        $event->update([
            'status' => 'disetujui',
            'alasan_penolakan' => null
        ]);

        return redirect()->route('event.show', $id_event)->with('success', 'Berhasil menyetujui pengajuan kegiatan tempat!');
    }

    public function tolak(Request $request, $id_event)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string'
        ]);

        $event = Event::where('id_event', $id_event)->firstOrFail();
        
        $event->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan
        ]);

        return redirect()->route('event.show', $id_event)->with('success', 'Pengajuan kegiatan telah berhasil ditolak.');
    }

    public function getRuanganByTanggal(Request $request)
    {
        $ruangans = Ruangan::where('is_delete', false)
            ->where('status_ruangan', 'tersedia')
            ->get();

        return response()->json($ruangans);
    }

    public function destroy($id_event)
    {
        $event = Event::where('id_event', $id_event)->firstOrFail();

        if ($event->status === 'disetujui' && auth()->user()->role === 'penyelenggara') {
            return redirect()->back()->with('error', 'Aksi ditolak! Event yang telah disetujui tidak boleh dihapus.');
        }

        $event->update(['is_delete' => true]);
        return redirect()->route('event.index')->with('success', 'Event berhasil dihapus!');
    }

    public function daftar($id_event)
    {
        $user = Auth::user();
        $userId = $user->id_user ?? $user->id;
        $event = Event::with(['ruangan', 'peserta'])->where('id_event', $id_event)->firstOrFail();

        if ($event->status !== 'disetujui' && $event->status !== 'approved') {
            return redirect()->back()->with('error', 'Gagal mendaftar! Kegiatan event ini belum aktif atau tidak disetujui.');
        }

        $sudahDaftar = \DB::table('peserta_events')
            ->where('id_event', $id_event)
            ->where('id_user', $userId)
            ->exists();

        if ($sudahDaftar) {
            return redirect()->back()->with('error', 'Anda sudah terdaftar sebagai peserta dalam kegiatan event ini!');
        }

        $jumlahPesertaSaatIni = $event->peserta()->count();
        if ($jumlahPesertaSaatIni >= $event->kuota) {
            return redirect()->back()->with('error', 'Maaf, pendaftaran gagal karena kuota batas maksimal peserta telah terpenuhi!');
        }

        if (\Carbon\Carbon::parse($event->tanggal_pelaksanaan)->isPast() && !\Carbon\Carbon::parse($event->tanggal_pelaksanaan)->isToday()) {
            return redirect()->back()->with('error', 'Gagal mendaftar! Kegiatan event ini sudah selesai dilaksanakan.');
        }

        \DB::table('peserta_events')->insert([
            'id_event' => $id_event,
            'id_user' => $userId,
            'tanggal_daftar' => date('Y-m-d'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Selamat, Anda berhasil terdaftar ke dalam event ' . $event->nama_event . '!');
    }
}