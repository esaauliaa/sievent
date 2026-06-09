@extends('layouts.' . Auth::user()->role)

@section('title', 'Presensi Event - SiEvent UNEJ')

@section('page-title', 'Presensi Event')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="bg-gradient-to-r from-[#0056B3] to-[#131D4F] rounded-3xl p-8 text-white shadow-lg relative overflow-hidden">
            <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full translate-x-20 -translate-y-20"></div>
            <div class="absolute right-24 bottom-0 w-32 h-32 bg-white/10 rounded-full translate-y-16"></div>

            <div class="relative z-10">
                <h2 class="text-3xl font-extrabold mb-3">Presensi Peserta</h2>
                <p class="text-white/85 max-w-2xl leading-relaxed">
                    Kelola kehadiran mahasiswa untuk event yang sudah disetujui.
                </p>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-blue-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-blue-100 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h3 class="text-lg font-extrabold text-[#131D4F]">Daftar Event Disetujui</h3>
                    <p class="text-sm text-gray-500 mt-1">Pilih event untuk melihat peserta yang terdaftar dan menandai kehadiran.</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('presensi.downloadAll') }}"
                           class="h-12 px-5 rounded-2xl bg-green-600 text-white hover:bg-green-700 transition font-extrabold shadow-sm inline-flex items-center justify-center gap-2 whitespace-nowrap">
                            <i class="fa-solid fa-file-excel"></i>
                            Download Semua Event
                        </a>
                    @endif

                    <div class="relative w-full sm:w-72">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input
                            id="searchPresensi"
                            type="text"
                            placeholder="Cari event..."
                            class="w-full h-12 pl-11 pr-4 rounded-2xl border-2 border-blue-100 bg-[#f8fbff] text-sm text-[#131D4F] focus:border-[#0056B3] focus:ring-1 focus:ring-[#0056B3]"
                        >
                    </div>

                    <select
                        id="filterEventStatus"
                        class="w-full sm:w-56 h-12 px-4 rounded-2xl border-2 border-blue-100 bg-[#f8fbff] text-sm text-[#131D4F] focus:border-[#0056B3] focus:ring-1 focus:ring-[#0056B3]"
                    >
                        <option value="">Semua Event</option>
                        <option value="terlaksana">Terlaksana</option>
                        <option value="belum-terlaksana">Belum Terlaksana</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-[#e1effe] text-[#131D4F]">
                        <tr>
                            <th class="px-6 py-4 text-sm font-extrabold text-center w-16">No</th>
                            <th class="px-6 py-4 text-sm font-extrabold">Nama Event</th>
                            <th class="px-6 py-4 text-sm font-extrabold">Ruangan</th>
                            <th class="px-6 py-4 text-sm font-extrabold">Tanggal</th>
                            <th class="px-6 py-4 text-sm font-extrabold text-center">Status Event</th>
                            <th class="px-6 py-4 text-sm font-extrabold text-center">Terdaftar</th>
                            <th class="px-6 py-4 text-sm font-extrabold text-center">Hadir</th>
                            <th class="px-6 py-4 text-sm font-extrabold text-center">Belum Hadir</th>
                            <th class="px-6 py-4 text-sm font-extrabold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="presensiTableBody" class="divide-y divide-blue-50 text-sm text-gray-700">
                        @forelse($events as $index => $event)
                            @php
                                $totalTerdaftar = $event->total_terdaftar ?? 0;
                                $totalHadir = $event->total_hadir ?? 0;
                                $totalBelumHadir = $totalTerdaftar - $totalHadir;
                                $persenHadir = $totalTerdaftar > 0 ? round(($totalHadir / $totalTerdaftar) * 100) : 0;
                                $waktuSelesaiEvent = \Carbon\Carbon::parse($event->tanggal_pelaksanaan . ' ' . $event->waktu_selesai);
                                $isTerlaksana = now()->greaterThan($waktuSelesaiEvent);
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition" data-event-status="{{ $isTerlaksana ? 'terlaksana' : 'belum-terlaksana' }}">
                                <td class="px-6 py-4 text-center text-gray-400 font-bold">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <p class="font-extrabold text-[#131D4F]">{{ $event->nama_event }}</p>
                                    <div class="mt-2 h-2 rounded-full bg-gray-100 overflow-hidden">
                                        <div class="h-full bg-green-500 rounded-full" style="width: {{ $persenHadir }}%"></div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-600">
                                    {{ $event->ruangan->nama_ruangan ?? 'Ruangan tidak ditemukan' }}
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($event->tanggal_pelaksanaan)->translatedFormat('d M Y') }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ substr($event->waktu_mulai, 0, 5) }} - {{ substr($event->waktu_selesai, 0, 5) }} WIB</p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($isTerlaksana)
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-bold">
                                            <i class="fa-solid fa-flag-checkered"></i> Terlaksana
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-blue-100 text-[#0056B3] text-xs font-bold">
                                            <i class="fa-solid fa-calendar-day"></i> Belum Terlaksana
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center font-extrabold text-[#131D4F]">{{ $totalTerdaftar }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">{{ $totalHadir }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold">{{ $totalBelumHadir }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex flex-col xl:flex-row items-center justify-center gap-2">
                                        <a href="{{ route('presensi.show', $event->id_event) }}"
                                           class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-[#0056B3] text-white text-xs font-extrabold hover:bg-[#131D4F] transition shadow-sm whitespace-nowrap">
                                            <i class="fa-solid fa-clipboard-check"></i> Kelola
                                        </a>

                                        <div class="flex items-center justify-center gap-1">
                                            <a href="{{ route('presensi.download', $event->id_event) }}"
                                               class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-green-600 text-white hover:bg-green-700 transition text-xs font-extrabold whitespace-nowrap"
                                               title="Download rekap Excel event ini">
                                                <i class="fa-solid fa-file-excel"></i> Excel
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-12 text-center text-gray-400 italic font-medium">
                                    Belum ada event disetujui yang bisa dipresensi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const searchPresensi = document.getElementById('searchPresensi');
        const filterEventStatus = document.getElementById('filterEventStatus');
        const presensiTableBody = document.getElementById('presensiTableBody');

        function filterPresensiTable() {
            const searchValue = searchPresensi.value.toLowerCase();
            const statusValue = filterEventStatus.value;
            const rows = presensiTableBody.getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                if (rows[i].cells.length < 4) continue;

                const eventName = rows[i].cells[1].textContent.toLowerCase();
                const roomName = rows[i].cells[2].textContent.toLowerCase();
                const eventStatus = rows[i].dataset.eventStatus || '';
                const matchesSearch = eventName.includes(searchValue) || roomName.includes(searchValue);
                const matchesStatus = statusValue === '' || eventStatus === statusValue;

                rows[i].style.display = matchesSearch && matchesStatus ? '' : 'none';
            }
        }

        searchPresensi.addEventListener('keyup', filterPresensiTable);
        filterEventStatus.addEventListener('change', filterPresensiTable);
    </script>
@endsection
