@extends('layouts.' . Auth::user()->role)

@section('title', 'Presensi Peserta - SiEvent')

@section('page-title', 'Presensi Peserta')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="bg-gradient-to-r from-[#0056B3] to-[#131D4F] rounded-3xl p-8 text-white shadow-lg relative overflow-hidden">
            <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full translate-x-20 -translate-y-20"></div>
            <div class="absolute right-24 bottom-0 w-32 h-32 bg-white/10 rounded-full translate-y-16"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-white/20 text-white mb-3">
                        Rekap Kehadiran
                    </span>
                    <h2 class="text-3xl font-extrabold mb-2">{{ $event->nama_event }}</h2>
                    <p class="text-white/85 text-sm">
                        {{ $event->ruangan->nama_ruangan ?? 'Ruangan tidak ditemukan' }} -
                        {{ \Carbon\Carbon::parse($event->tanggal_pelaksanaan)->translatedFormat('d F Y') }}
                    </p>
                </div>

                <a href="{{ route('presensi.index') }}"
                   class="px-5 py-3 rounded-2xl bg-white/10 text-white hover:bg-white/20 transition font-bold shadow-md border border-white/20 text-center whitespace-nowrap text-sm">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="p-4 rounded-2xl bg-green-100 text-green-700 font-bold">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white border border-blue-100 p-5 rounded-3xl shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-500 text-white rounded-2xl flex items-center justify-center text-lg shadow-sm">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase">Total Pendaftar</p>
                    <p class="text-2xl font-black text-blue-900">{{ $totalTerdaftar }}</p>
                </div>
            </div>

            <div class="bg-white border border-green-100 p-5 rounded-3xl shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 bg-green-500 text-white rounded-2xl flex items-center justify-center text-lg shadow-sm">
                    <i class="fa-solid fa-user-check"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase">Sudah Hadir</p>
                    <p class="text-2xl font-black text-green-900">{{ $totalHadir }}</p>
                </div>
            </div>

            <div class="bg-white border border-amber-100 p-5 rounded-3xl shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 bg-amber-500 text-white rounded-2xl flex items-center justify-center text-lg shadow-sm">
                    <i class="fa-solid fa-user-clock"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase">Belum Hadir</p>
                    <p class="text-2xl font-black text-amber-900">{{ $totalBelumHadir }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-blue-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-blue-100 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <h3 class="font-extrabold text-[#131D4F] text-lg">Daftar Peserta</h3>
                    <p class="text-sm text-gray-500 mt-1">Penyelenggara dapat menandai peserta hadir atau mengembalikan statusnya ke belum hadir.</p>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                    <span class="text-xs font-bold bg-[#e1effe] px-3 py-2 rounded-xl text-[#0056B3] text-center">
                        {{ substr($event->waktu_mulai, 0, 5) }} - {{ substr($event->waktu_selesai, 0, 5) }} WIB
                    </span>

                    <a href="{{ route('presensi.download', $event->id_event) }}"
                       class="inline-flex items-center justify-center gap-2 px-3 py-2 rounded-xl bg-green-600 text-white text-xs font-extrabold hover:bg-green-700 transition shadow-sm whitespace-nowrap">
                        <i class="fa-solid fa-file-excel"></i> Download Excel
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-[#e1effe] text-[#131D4F]">
                        <tr>
                            <th class="px-6 py-4 text-sm font-extrabold text-center w-16">No</th>
                            <th class="px-6 py-4 text-sm font-extrabold">Nama Peserta</th>
                            <th class="px-6 py-4 text-sm font-extrabold">NIM / Email</th>
                            <th class="px-6 py-4 text-sm font-extrabold">Tanggal Daftar</th>
                            <th class="px-6 py-4 text-sm font-extrabold text-center">Status</th>
                            <th class="px-6 py-4 text-sm font-extrabold text-center">Jam Presensi</th>
                            <th class="px-6 py-4 text-sm font-extrabold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-blue-50 text-sm text-gray-700">
                        @forelse($pesertas as $index => $peserta)
                            @php
                                $isHadir = $peserta->status_kehadiran === 'hadir';
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-6 py-4 text-center text-gray-400 font-bold">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <p class="font-extrabold text-[#131D4F]">{{ $peserta->user->nama ?? 'Pengguna tidak ditemukan' }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">ID Peserta: {{ $peserta->id_peserta }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-700">{{ $peserta->user->nim ?? '-' }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $peserta->user->email ?? '-' }}</p>
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-600">
                                    {{ $peserta->tanggal_daftar ? $peserta->tanggal_daftar->translatedFormat('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($isHadir)
                                        <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-bold bg-green-100 text-green-700 rounded-full">
                                            <i class="fa-solid fa-circle-check"></i> Hadir
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-bold bg-amber-100 text-amber-700 rounded-full">
                                            <i class="fa-solid fa-clock"></i> Belum Hadir
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center text-xs text-gray-500 font-mono">
                                    {{ $peserta->waktu_presensi ? $peserta->waktu_presensi->format('H:i:s') . ' WIB' : '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center">
                                        <form action="{{ route('presensi.update', [$event->id_event, $peserta->id_peserta]) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status_kehadiran" value="{{ $isHadir ? 'belum_hadir' : 'hadir' }}">
                                            <button type="submit"
                                                    class="px-4 py-2 rounded-xl text-xs font-extrabold transition shadow-sm {{ $isHadir ? 'bg-gray-100 text-gray-600 hover:bg-gray-200' : 'bg-[#0056B3] text-white hover:bg-[#131D4F]' }}">
                                                {{ $isHadir ? 'Batalkan Hadir' : 'Tandai Hadir' }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-400 italic font-medium">
                                    Belum ada mahasiswa yang mendaftar pada kegiatan ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
