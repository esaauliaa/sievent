@extends('layouts.admin')

@section('title', 'Dashboard Admin - SiEvent UNEJ')

@section('page-title', 'Dashboard Admin')

@section('content')
    <div class="mb-8">
        <div class="bg-gradient-to-r from-[#0056B3] to-[#131D4F] rounded-3xl p-8 text-white shadow-lg relative overflow-hidden">
            <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full translate-x-20 -translate-y-20"></div>
            <div class="absolute right-24 bottom-0 w-32 h-32 bg-white/10 rounded-full translate-y-16"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h2 class="text-3xl font-extrabold mb-3">
                        Halo, {{ Auth::user()->nama ?? 'Admin' }} 👋
                    </h2>
                    <p class="text-white/85 max-w-2xl leading-relaxed">
                        Selamat datang di dashboard admin SiEvent UNEJ. Admin dapat mengelola data ruangan,
                        mengkonfirmasi pengajuan event, dan memantau data event dalam sistem.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <x-admin-stat-card
            title="Total Semua Event"
            value="{{ $totalEvent }}"
            subtitle="Keseluruhan event"
            icon="fa-solid fa-calendar-days"
            color="#0056B3"
        />

        <x-admin-stat-card
            title="Pengajuan Event"
            value="{{ $eventPending }}"
            subtitle="Belum dikonfirmasi"
            icon="fa-solid fa-clock"
            color="#954C2E"
        />

        <x-admin-stat-card
            title="Event Disetujui"
            value="{{ $totalEventDisetujui }}"
            subtitle="Event aktif saat ini"
            icon="fa-solid fa-circle-check"
            color="#131D4F"
        />

        <x-admin-stat-card
            title="Total Ruangan"
            value="{{ $totalRuangan }}"
            subtitle="Ruangan terdaftar"
            icon="fa-solid fa-door-open"
            color="#0056B3"
        />
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        
        <div class="xl:col-span-2 bg-white rounded-3xl border border-blue-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-blue-100 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-extrabold text-[#131D4F]">
                        Pengajuan Event Terbaru
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Daftar event yang menunggu konfirmasi admin.
                    </p>
                </div>

                <a href="{{ route('event.index') }}" class="text-sm font-bold text-[#0056B3] hover:underline">
                    Lihat Semua Event
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-[#e1effe] text-[#131D4F]">
                        <tr>
                            <th class="px-6 py-4 text-sm font-extrabold">Nama Event</th>
                            <th class="px-6 py-4 text-sm font-extrabold">ID Ruangan</th>
                            <th class="px-6 py-4 text-sm font-extrabold">Tanggal</th>
                            <th class="px-6 py-4 text-sm font-extrabold">Status</th>
                            <th class="px-6 py-4 text-sm font-extrabold text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-blue-50">
                        @forelse($events as $item)
                            <tr class="hover:bg-blue-50/50 transition">
                                <td class="px-6 py-4 font-semibold text-[#131D4F]">
                                    {{ $item->nama_event }}
                                </td>
                                <td class="px-6 py-4 text-gray-600 font-medium">
                                    ID-{{ $item->id_ruangan }}
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">
                                        Pending
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('event.show', $item->id_event ?? $item->id) }}" 
                                        class="px-3 py-1.5 rounded-xl bg-gray-100 text-[#131D4F] text-xs font-bold hover:bg-gray-200 transition shadow-sm flex items-center gap-1">
                                            <i class="fa-solid fa-eye"></i> Detail
                                        </a>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400 italic font-medium">
                                    Tidak ada pengajuan event baru yang menunggu persetujuan.
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
                    Event Hari Ini
                </h3>
                <p class="text-sm text-gray-500 mt-1">
                    Kegiatan berlangsung hari ini ({{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}).
                </p>
            </div>

            <div class="p-6 space-y-4">
                @forelse($eventHariIni as $hariIni)
                    <div class="p-4 rounded-2xl bg-[#e1effe] border border-blue-100 hover:shadow-sm transition">
                        <p class="font-bold text-[#131D4F] text-base">
                            {{ $hariIni->nama_event }}
                        </p>
                        <p class="text-sm text-gray-600 mt-1 flex items-center gap-1.5">
                            <i class="fa-solid fa-building text-xs text-gray-400"></i>
                            ID Ruangan: {{ $hariIni->id_ruangan }}
                        </p>
                        <p class="text-xs text-[#0056B3] font-bold mt-2 flex items-center gap-1.5">
                            <i class="fa-solid fa-clock text-xs"></i>
                            {{ substr($hariIni->waktu_mulai, 0, 5) }} - {{ substr($hariIni->waktu_selesai, 0, 5) }} WIB
                        </p>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-400 italic font-medium bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <i class="fa-solid fa-calendar-xmark block text-2xl mb-2 text-gray-300"></i>
                        Tidak ada agenda kegiatan untuk hari ini.
                    </div>
                @endforelse
            </div>
        </div>

    </div>
    @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-2xl font-semibold">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-2xl font-semibold">
        {{ session('error') }}
    </div>
@endif
@endsection