@extends('layouts.' . Auth::user()->role)

@section('title', 'Rekap Presensi Peserta - SiEvent')

@section('content')
<div class="container mx-auto px-4 py-6 space-y-6">
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-gray-100 pb-4">
        <div>
            <h2 class="text-xl font-extrabold text-[#131D4F]">Monitoring Kehadiran Peserta</h2>
            <p class="text-xs text-gray-500 mt-1">Kegiatan: <span class="text-[#0056B3] font-bold">{{ $event->nama_event }}</span></p>
        </div>
        <a href="{{ route('event.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 text-xs font-bold rounded-xl hover:bg-gray-200 transition inline-block">
            ← Kembali ke Daftar Event
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-blue-50/50 border border-blue-100 p-4 rounded-2xl flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-500 text-white rounded-xl flex items-center justify-center text-lg shadow-sm">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase">Total Pendaftar</p>
                <p class="text-lg font-black text-blue-900">{{ $totalTerdaftar }} Orang</p>
            </div>
        </div>

        <div class="bg-green-50/50 border border-green-100 p-4 rounded-2xl flex items-center gap-3">
            <div class="w-10 h-10 bg-green-500 text-white rounded-xl flex items-center justify-center text-lg shadow-sm">
                <i class="fa-solid fa-user-check"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase">Sudah Hadir (Scan)</p>
                <p class="text-lg font-black text-green-900">{{ $totalHadir }} Orang</p>
            </div>
        </div>

        <div class="bg-amber-50/50 border border-amber-100 p-4 rounded-2xl flex items-center gap-3">
            <div class="w-10 h-10 bg-amber-500 text-white rounded-xl flex items-center justify-center text-lg shadow-sm">
                <i class="fa-solid fa-user-clock"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase">Belum Datang</p>
                <p class="text-lg font-black text-amber-900">{{ $totalBelumHadir }} Orang</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-50 flex items-center justify-between">
            <h3 class="font-extrabold text-[#131D4F] text-sm">Daftar Hadir Mahasiswa</h3>
            <span class="text-[11px] font-bold bg-slate-100 px-3 py-1 rounded-full text-slate-600">Real-time Update</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 text-[10px] font-bold uppercase tracking-wider border-b border-slate-100">
                        <th class="p-4 w-12 text-center">No</th>
                        <th class="p-4">Nama Peserta</th>
                        <th class="p-4">Email</th>
                        <th class="p-4 text-center">Status Kehadiran</th>
                        <th class="p-4 text-center">Jam Check-In</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-sm text-gray-700 font-medium">
                    @forelse($pesertas as $index => $peserta)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4 text-center text-xs text-gray-400 font-bold">{{ $index + 1 }}</td>
                            <td class="p-4 text-slate-800 font-bold">{{ $peserta->user->name }}</td>
                            <td class="p-4 text-xs font-mono text-gray-500">{{ $peserta->user->email }}</td>
                            <td class="p-4 text-center">
                                @if($peserta->status_kehadiran === 'hadir')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 text-[11px] font-bold bg-green-100 text-green-700 rounded-full">
                                        ✓ Hadir
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 text-[11px] font-bold bg-amber-100 text-amber-700 rounded-full">
                                        ● Belum Hadir
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-center text-xs text-gray-500 font-mono">
                                {{ $peserta->waktu_presensi ? date('H:i:s \W\I\B', strtotime($peserta->waktu_presensi)) : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center text-gray-400 text-xs">
                                <i class="fa-solid fa-folder-open block text-2xl mb-2 text-gray-300"></i>
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