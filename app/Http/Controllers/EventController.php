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

            $myEventIds = \DB::table('peserta_events')
                ->where('id_user', $userId)
                ->pluck('id_event')
                ->toArray();
        } elseif ($user->role === 'penyelenggara') {
            $events = Event::with('ruangan')
                ->where('is_delete', false)
                ->where('id_user', $userId) 
                ->latest()
                ->get();

            $myEventIds = [];
        } else {
            $events = Event::with('ruangan')->where('is_delete', false)->latest()->get();
            $myEventIds = [];
        }

        return view('event.index', compact('events', 'myEventIds'));
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
            'status_kehadiran' => 'belum_hadir',
            'waktu_presensi' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Selamat, Anda berhasil terdaftar ke dalam event ' . $event->nama_event . '!');
    }

    public function presensiIndex()
    {
        $user = Auth::user();
        abort_unless(in_array($user->role, ['admin', 'penyelenggara']), 403);

        $eventsQuery = Event::with('ruangan')
            ->withCount([
                'pesertaEvents as total_terdaftar',
                'pesertaEvents as total_hadir' => function ($query) {
                    $query->where('status_kehadiran', 'hadir');
                },
            ])
            ->where('is_delete', false)
            ->whereIn('status', ['disetujui', 'approved']);

        if ($user->role === 'penyelenggara') {
            $eventsQuery->where('id_user', $user->id_user ?? $user->id);
        }

        $events = $eventsQuery
            ->orderBy('tanggal_pelaksanaan', 'desc')
            ->orderBy('waktu_mulai', 'desc')
            ->get();

        return view('event.presensi_index', compact('events'));
    }

    public function presensiShow($id_event)
    {
        $user = Auth::user();
        abort_unless(in_array($user->role, ['admin', 'penyelenggara']), 403);

        $eventQuery = Event::with('ruangan')
            ->where('is_delete', false)
            ->whereIn('status', ['disetujui', 'approved'])
            ->where('id_event', $id_event);

        if ($user->role === 'penyelenggara') {
            $eventQuery->where('id_user', $user->id_user ?? $user->id);
        }

        $event = $eventQuery->firstOrFail();

        $pesertas = Peserta::with('user')
            ->where('id_event', $id_event)
            ->orderBy('tanggal_daftar', 'asc')
            ->orderBy('id_peserta', 'asc')
            ->get();

        $totalTerdaftar = $pesertas->count();
        $totalHadir = $pesertas->where('status_kehadiran', 'hadir')->count();
        $totalBelumHadir = $totalTerdaftar - $totalHadir;

        return view('event.index_presensi', compact(
            'event',
            'pesertas',
            'totalTerdaftar',
            'totalHadir',
            'totalBelumHadir'
        ));
    }

    public function updatePresensi(Request $request, $id_event, $id_peserta)
    {
        $user = Auth::user();
        abort_unless(in_array($user->role, ['admin', 'penyelenggara']), 403);

        $validated = $request->validate([
            'status_kehadiran' => 'required|in:hadir,belum_hadir',
        ]);

        $eventQuery = Event::where('id_event', $id_event)
            ->where('is_delete', false)
            ->whereIn('status', ['disetujui', 'approved']);

        if ($user->role === 'penyelenggara') {
            $eventQuery->where('id_user', $user->id_user ?? $user->id);
        }

        $eventQuery->firstOrFail();

        $peserta = Peserta::with('user')
            ->where('id_event', $id_event)
            ->where('id_peserta', $id_peserta)
            ->firstOrFail();

        $peserta->update([
            'status_kehadiran' => $validated['status_kehadiran'],
            'waktu_presensi' => $validated['status_kehadiran'] === 'hadir' ? now() : null,
        ]);

        $namaPeserta = $peserta->user->nama ?? 'Peserta';
        $pesan = $validated['status_kehadiran'] === 'hadir'
            ? "{$namaPeserta} ditandai hadir."
            : "{$namaPeserta} dikembalikan ke status belum hadir.";

        return redirect()->route('presensi.show', $id_event)->with('success', $pesan);
    }

    public function downloadPresensi(Request $request, $id_event)
    {
        $user = Auth::user();
        abort_unless(in_array($user->role, ['admin', 'penyelenggara']), 403);

        $eventQuery = Event::with('ruangan')
            ->where('id_event', $id_event)
            ->where('is_delete', false)
            ->whereIn('status', ['disetujui', 'approved']);

        if ($user->role === 'penyelenggara') {
            $eventQuery->where('id_user', $user->id_user ?? $user->id);
        }

        $event = $eventQuery->firstOrFail();

        $pesertas = Peserta::with('user')
            ->where('id_event', $id_event)
            ->orderByRaw("CASE WHEN status_kehadiran = 'hadir' THEN 0 ELSE 1 END")
            ->orderBy('tanggal_daftar', 'asc')
            ->orderBy('id_peserta', 'asc')
            ->get();
        $fileEventName = trim(strtolower(preg_replace('/[^A-Za-z0-9]+/', '-', $event->nama_event)), '-');
        $filename = 'rekap-presensi-' . ($fileEventName ?: 'event') . '.xls';

        return response()->streamDownload(function () use ($event, $pesertas) {
            $escape = fn ($value) => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
            $totalTerdaftar = $pesertas->count();
            $totalHadir = $pesertas->where('status_kehadiran', 'hadir')->count();
            $totalBelumHadir = $totalTerdaftar - $totalHadir;

            echo "\xEF\xBB\xBF";
            echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
            echo '<head><meta charset="UTF-8">';
            echo '<style>
                body { font-family: Arial, sans-serif; color: #111827; }
                .title { font-size: 22px; font-weight: 700; color: #131D4F; background: #dbeafe; }
                .subtitle { font-size: 13px; font-weight: 700; background: #eff6ff; }
                .label { font-weight: 700; background: #f8fafc; width: 160px; }
                .summary-label { font-weight: 700; color: #475569; background: #f8fafc; text-align: center; }
                .summary-value { font-size: 18px; font-weight: 700; text-align: center; }
                .header { font-weight: 700; color: #ffffff; background: #0056B3; text-align: center; }
                .center { text-align: center; }
                .text { mso-number-format: "\@"; }
                .hadir { color: #166534; background: #dcfce7; font-weight: 700; text-align: center; }
                .belum { color: #92400e; background: #fef3c7; font-weight: 700; text-align: center; }
                td, th { border: 1px solid #cbd5e1; padding: 8px; vertical-align: middle; }
            </style>';
            echo '</head><body>';
            echo '<table>';
            echo '<tr><td colspan="7" class="title">REKAP PRESENSI SIEVENT</td></tr>';
            echo '<tr><td class="label">Nama Event</td><td colspan="6">' . $escape($event->nama_event) . '</td></tr>';
            echo '<tr><td class="label">Ruangan</td><td colspan="6">' . $escape($event->ruangan->nama_ruangan ?? '-') . '</td></tr>';
            echo '<tr><td class="label">Tanggal Event</td><td colspan="6">' . $escape(Carbon::parse($event->tanggal_pelaksanaan)->translatedFormat('d F Y')) . '</td></tr>';
            echo '<tr><td class="label">Waktu Event</td><td colspan="6">' . $escape(substr($event->waktu_mulai, 0, 5) . ' - ' . substr($event->waktu_selesai, 0, 5) . ' WIB') . '</td></tr>';
            echo '<tr><td class="label">Urutan Rekap</td><td colspan="6">Peserta hadir ditampilkan terlebih dahulu, lalu peserta belum hadir.</td></tr>';
            echo '<tr><td class="label">Dicetak Pada</td><td colspan="6">' . $escape(now()->format('d/m/Y H:i:s') . ' WIB') . '</td></tr>';
            echo '<tr><td colspan="7"></td></tr>';
            echo '<tr>';
            echo '<td class="summary-label" colspan="2">Total Data Diunduh</td>';
            echo '<td class="summary-label" colspan="2">Hadir</td>';
            echo '<td class="summary-label" colspan="3">Belum Hadir</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td class="summary-value" colspan="2">' . $totalTerdaftar . '</td>';
            echo '<td class="summary-value hadir" colspan="2">' . $totalHadir . '</td>';
            echo '<td class="summary-value belum" colspan="3">' . $totalBelumHadir . '</td>';
            echo '</tr>';
            echo '<tr><td colspan="7"></td></tr>';
            echo '<tr>';
            echo '<th class="header">No</th>';
            echo '<th class="header">Nama Peserta</th>';
            echo '<th class="header">NIM</th>';
            echo '<th class="header">Email</th>';
            echo '<th class="header">Tanggal Daftar</th>';
            echo '<th class="header">Status Kehadiran</th>';
            echo '<th class="header">Jam Presensi</th>';
            echo '</tr>';

            foreach ($pesertas as $index => $peserta) {
                $isHadir = $peserta->status_kehadiran === 'hadir';
                echo '<tr>';
                echo '<td class="center">' . ($index + 1) . '</td>';
                echo '<td>' . $escape($peserta->user->nama ?? '-') . '</td>';
                echo '<td class="text">' . $escape($peserta->user->nim ?? '-') . '</td>';
                echo '<td>' . $escape($peserta->user->email ?? '-') . '</td>';
                echo '<td class="center">' . $escape($peserta->tanggal_daftar ? $peserta->tanggal_daftar->format('d/m/Y') : '-') . '</td>';
                echo '<td class="' . ($isHadir ? 'hadir' : 'belum') . '">' . ($isHadir ? 'Hadir' : 'Belum Hadir') . '</td>';
                echo '<td class="center">' . $escape($peserta->waktu_presensi ? $peserta->waktu_presensi->format('H:i:s') . ' WIB' : '-') . '</td>';
                echo '</tr>';
            }

            if ($pesertas->isEmpty()) {
                echo '<tr><td colspan="7" class="center">Tidak ada data peserta pada rekap ini.</td></tr>';
            }

            echo '</table>';
            echo '</body></html>';
        }, $filename, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
        ]);
    }

    public function downloadSemuaPresensi()
    {
        $user = Auth::user();
        abort_unless($user->role === 'admin', 403);

        $events = Event::with(['ruangan', 'pesertaEvents.user'])
            ->where('is_delete', false)
            ->whereIn('status', ['disetujui', 'approved'])
            ->orderBy('tanggal_pelaksanaan', 'desc')
            ->orderBy('waktu_mulai', 'desc')
            ->get();

        return response()->streamDownload(function () use ($events) {
            $escape = fn ($value) => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
            $totalPeserta = $events->sum(fn ($event) => $event->pesertaEvents->count());
            $totalHadir = $events->sum(fn ($event) => $event->pesertaEvents->where('status_kehadiran', 'hadir')->count());
            $totalBelumHadir = $totalPeserta - $totalHadir;

            echo "\xEF\xBB\xBF";
            echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
            echo '<head><meta charset="UTF-8">';
            echo '<style>
                body { font-family: Arial, sans-serif; color: #111827; }
                .title { font-size: 22px; font-weight: 700; color: #131D4F; background: #dbeafe; }
                .section { font-size: 16px; font-weight: 700; color: #ffffff; background: #131D4F; }
                .label { font-weight: 700; background: #f8fafc; width: 160px; }
                .summary-label { font-weight: 700; color: #475569; background: #f8fafc; text-align: center; }
                .summary-value { font-size: 18px; font-weight: 700; text-align: center; }
                .header { font-weight: 700; color: #ffffff; background: #0056B3; text-align: center; }
                .center { text-align: center; }
                .text { mso-number-format: "\@"; }
                .hadir { color: #166534; background: #dcfce7; font-weight: 700; text-align: center; }
                .belum { color: #92400e; background: #fef3c7; font-weight: 700; text-align: center; }
                td, th { border: 1px solid #cbd5e1; padding: 8px; vertical-align: middle; }
            </style>';
            echo '</head><body>';
            echo '<table>';
            echo '<tr><td colspan="8" class="title">REKAP PRESENSI SEMUA EVENT SIEVENT</td></tr>';
            echo '<tr><td class="label">Dicetak Pada</td><td colspan="7">' . $escape(now()->format('d/m/Y H:i:s') . ' WIB') . '</td></tr>';
            echo '<tr><td class="label">Urutan Rekap</td><td colspan="7">Setiap event menampilkan peserta hadir terlebih dahulu, lalu peserta belum hadir.</td></tr>';
            echo '<tr><td colspan="8"></td></tr>';
            echo '<tr>';
            echo '<td class="summary-label" colspan="2">Total Event</td>';
            echo '<td class="summary-label" colspan="2">Total Peserta</td>';
            echo '<td class="summary-label" colspan="2">Hadir</td>';
            echo '<td class="summary-label" colspan="2">Belum Hadir</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td class="summary-value" colspan="2">' . $events->count() . '</td>';
            echo '<td class="summary-value" colspan="2">' . $totalPeserta . '</td>';
            echo '<td class="summary-value hadir" colspan="2">' . $totalHadir . '</td>';
            echo '<td class="summary-value belum" colspan="2">' . $totalBelumHadir . '</td>';
            echo '</tr>';
            echo '<tr><td colspan="8"></td></tr>';

            foreach ($events as $event) {
                $pesertas = $event->pesertaEvents
                    ->sortBy([
                        fn ($a, $b) => ($a->status_kehadiran === 'hadir' ? 0 : 1) <=> ($b->status_kehadiran === 'hadir' ? 0 : 1),
                        fn ($a, $b) => strcmp((string) $a->tanggal_daftar, (string) $b->tanggal_daftar),
                        fn ($a, $b) => $a->id_peserta <=> $b->id_peserta,
                    ])
                    ->values();
                $eventTotal = $pesertas->count();
                $eventHadir = $pesertas->where('status_kehadiran', 'hadir')->count();
                $eventBelumHadir = $eventTotal - $eventHadir;

                echo '<tr><td colspan="8" class="section">' . $escape($event->nama_event) . '</td></tr>';
                echo '<tr><td class="label">Ruangan</td><td colspan="3">' . $escape($event->ruangan->nama_ruangan ?? '-') . '</td><td class="label">Tanggal</td><td colspan="3">' . $escape(Carbon::parse($event->tanggal_pelaksanaan)->translatedFormat('d F Y')) . '</td></tr>';
                echo '<tr><td class="label">Waktu</td><td colspan="3">' . $escape(substr($event->waktu_mulai, 0, 5) . ' - ' . substr($event->waktu_selesai, 0, 5) . ' WIB') . '</td><td class="label">Ringkasan</td><td colspan="3">' . $eventTotal . ' peserta, ' . $eventHadir . ' hadir, ' . $eventBelumHadir . ' belum hadir</td></tr>';
                echo '<tr>';
                echo '<th class="header">No</th>';
                echo '<th class="header">Nama Peserta</th>';
                echo '<th class="header">NIM</th>';
                echo '<th class="header">Email</th>';
                echo '<th class="header">Tanggal Daftar</th>';
                echo '<th class="header">Status Kehadiran</th>';
                echo '<th class="header">Jam Presensi</th>';
                echo '<th class="header">Keterangan</th>';
                echo '</tr>';

                foreach ($pesertas as $index => $peserta) {
                    $isHadir = $peserta->status_kehadiran === 'hadir';
                    echo '<tr>';
                    echo '<td class="center">' . ($index + 1) . '</td>';
                    echo '<td>' . $escape($peserta->user->nama ?? '-') . '</td>';
                    echo '<td class="text">' . $escape($peserta->user->nim ?? '-') . '</td>';
                    echo '<td>' . $escape($peserta->user->email ?? '-') . '</td>';
                    echo '<td class="center">' . $escape($peserta->tanggal_daftar ? $peserta->tanggal_daftar->format('d/m/Y') : '-') . '</td>';
                    echo '<td class="' . ($isHadir ? 'hadir' : 'belum') . '">' . ($isHadir ? 'Hadir' : 'Belum Hadir') . '</td>';
                    echo '<td class="center">' . $escape($peserta->waktu_presensi ? $peserta->waktu_presensi->format('H:i:s') . ' WIB' : '-') . '</td>';
                    echo '<td></td>';
                    echo '</tr>';
                }

                if ($pesertas->isEmpty()) {
                    echo '<tr><td colspan="8" class="center">Belum ada peserta yang mendaftar pada event ini.</td></tr>';
                }

                echo '<tr><td colspan="8"></td></tr>';
            }

            if ($events->isEmpty()) {
                echo '<tr><td colspan="8" class="center">Belum ada event disetujui yang bisa direkap.</td></tr>';
            }

            echo '</table>';
            echo '</body></html>';
        }, 'rekap-presensi-semua-event.xls', [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
        ]);
    }

    public function presensiMahasiswa()
    {
        abort_unless(Auth::user()->role === 'mahasiswa', 403);

        $user = Auth::user();
        $userId = $user->id_user ?? $user->id;

        $presensis = Peserta::with(['event.ruangan'])
            ->where('id_user', $userId)
            ->orderBy('tanggal_daftar', 'desc')
            ->orderBy('id_peserta', 'desc')
            ->get();

        $totalEventDiikuti = $presensis->count();
        $totalHadir = $presensis->where('status_kehadiran', 'hadir')->count();
        $totalBelumHadir = $totalEventDiikuti - $totalHadir;

        return view('event.presensi_mahasiswa', compact(
            'presensis',
            'totalEventDiikuti',
            'totalHadir',
            'totalBelumHadir'
        ));
    }
}
