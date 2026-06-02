@extends('layouts.penyelenggara')

@section('title', 'Dashboard Penyelenggara - SiEvent UNEJ')

@section('page-title', 'Dashboard Penyelenggara')

@section('content')
    <div class="mb-8">
        <div class="bg-gradient-to-r from-[#0056B3] to-[#131D4F] rounded-3xl p-8 text-white shadow-lg relative overflow-hidden">
            <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full translate-x-20 -translate-y-20"></div>
            <div class="absolute right-24 bottom-0 w-32 h-32 bg-white/10 rounded-full translate-y-16"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h2 class="text-3xl font-extrabold mb-3">
                        Halo, {{ Auth::user()->nama ?? 'Penyelenggara' }} 
                    </h2>

                    <p class="text-white/85 max-w-2xl leading-relaxed text-sm">
                        Selamat datang di dashboard penyelenggara SiEvent UNEJ.
                        Kelola pengajuan event, export data peserta dan presensi, serta cek jadwal event Anda dengan mudah.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <x-penyelenggara-stat-card
            title="Event Saya"
            value="{{ $totalEventDibuat }}"
            subtitle="Total event yang dibuat"
            icon="fa-solid fa-calendar-days"
            color="#0056B3"
        />

        <x-penyelenggara-stat-card
            title="Menunggu Konfirmasi"
            value="{{ $eventPendingCount }}"
            subtitle="Event belum disetujui admin"
            icon="fa-solid fa-clock"
            color="#131D4F"
        />
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 bg-white rounded-3xl border border-blue-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-blue-100 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-extrabold text-[#131D4F]">
                        Event Terbaru yang Dibuat
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Daftar event terbaru yang Anda ajukan.
                    </p>
                </div>

                <a href="{{ route('event.index') }}" class="text-sm font-bold text-[#0056B3] hover:underline">
                    Lihat Semua
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-[#e1effe] text-[#131D4F]">
                        <tr>
                            <th class="px-6 py-4 text-sm font-extrabold">Nama Event</th>
                            <th class="px-6 py-4 text-sm font-extrabold">Tanggal</th>
                            <th class="px-6 py-4 text-sm font-extrabold">Ruangan</th>
                            <th class="px-6 py-4 text-sm font-extrabold">Status</th>
                            <th class="px-6 py-4 text-sm font-extrabold text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-blue-50">
                        @forelse($eventTerbaru as $item)
                            <tr class="hover:bg-blue-50/50 transition">
                                <td class="px-6 py-4 font-semibold text-[#131D4F]">
                                    {{ $item->nama_event }}
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    ID-{{ $item->id_ruangan }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->status === 'disetujui' || $item->status === 'approved')
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                            Approved
                                        </span>
                                    @elseif($item->status === 'pending')
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">
                                            Pending
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                            Rejected
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('event.show', $item->id_event ?? $item->id) }}" class="px-4 py-2 rounded-xl bg-[#0056B3] text-white text-sm font-bold hover:bg-[#131D4F] transition shadow-sm inline-block">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400 italic font-medium">
                                    Belum ada data riwayat pengajuan kegiatan saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-blue-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-blue-100">
                <h3 class="text-lg font-extrabold text-[#131D4F]">
                    Jadwal Event Saya
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    Event Anda yang akan berlangsung.
                </p>
            </div>

            <div class="p-6 space-y-4">
                @forelse($jadwalEventSaya as $jadwal)
                    <div class="p-4 rounded-2xl bg-[#e1effe] border border-blue-100 hover:shadow-sm transition flex gap-4 items-center">
                        
                        <div class="w-14 h-16 bg-gray-200 rounded-xl overflow-hidden shadow-inner flex-shrink-0 flex items-center justify-center border border-blue-100">
                            @if(!empty($jadwal->poster))
                                <img src="{{ asset('storage/' . $jadwal->poster) }}" alt="Poster" class="w-full h-full object-cover">
                            @else
                                <i class="fa-solid fa-image text-blue-300 text-lg"></i>
                            @endif
                        </div>

                        <div class="min-w-0 flex-1">
                            <p class="font-bold text-[#131D4F] text-sm truncate">
                                {{ $jadwal->nama_event }}
                            </p>

                            <p class="text-xs text-gray-600 mt-0.5 flex items-center gap-1">
                                <i class="fa-solid fa-building text-gray-400 text-[10px]"></i>
                                ID Ruangan: {{ $jadwal->id_ruangan }}
                            </p>

                            <p class="text-[10px] text-[#0056B3] font-extrabold mt-1.5 flex items-center gap-1">
                                <i class="fa-solid fa-calendar-day"></i>
                                {{ \Carbon\Carbon::parse($jadwal->tanggal_pelaksanaan)->translatedFormat('d M Y') }} • {{ substr($jadwal->waktu_mulai, 0, 5) }} WIB
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-400 italic font-medium bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <i class="fa-solid fa-calendar-xmark block text-2xl mb-2 text-gray-300"></i>
                        Belum ada jadwal kegiatan aktif yang disetujui dalam waktu dekat.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection