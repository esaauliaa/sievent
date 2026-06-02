@extends('layouts.' . Auth::user()->role)

@section('title', 'Data Event - SiEvent UNEJ')

@section('page-title', 'Data Event')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="mb-8">
            <div class="bg-gradient-to-r from-[#0056B3] to-[#131D4F] rounded-3xl p-8 text-white shadow-lg relative overflow-hidden">
                <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full translate-x-20 -translate-y-20"></div>
                <div class="absolute right-24 bottom-0 w-32 h-32 bg-white/10 rounded-full translate-y-16"></div>

                <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <h2 class="text-3xl font-extrabold mb-3">
                            Data Event
                        </h2>

                        <p class="text-white/85 max-w-2xl leading-relaxed">
                            Halaman ini digunakan untuk melihat informasi event, status verifikasi,
                            dan lokasi pelaksanaan untuk seluruh kegiatan Universitas Jember.
                        </p>
                    </div>

                    @if (Auth::user()->role !== 'admin')
                        <a
                            href="{{ route('event.create') }}"
                            class="px-6 py-3 rounded-2xl bg-white text-[#0056B3] hover:bg-[#e1effe] transition font-bold shadow-md whitespace-nowrap"
                        >
                            <i class="fa-solid fa-plus mr-2"></i>
                            Tambah Event
                        </a>
                    @endif
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-green-100 text-green-700 font-bold">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-red-100 text-red-700 font-bold">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl border border-blue-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-blue-100 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
                <div>
                    <h3 class="text-lg font-extrabold text-[#131D4F]">
                        Daftar Event
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Menampilkan seluruh data event yang terdaftar di Universitas Jember.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                    <div class="relative w-full sm:w-72">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>

                        <input
                            id="searchEvent"
                            type="text"
                            placeholder="Cari event..."
                            class="w-full h-12 pl-11 pr-4 rounded-2xl border-2 border-blue-100 bg-[#f8fbff] text-sm text-[#131D4F] focus:border-[#0056B3] focus:ring-1 focus:ring-[#0056B3]"
                        >
                    </div>

                    <select
                        id="filterStatus"
                        class="w-full sm:w-56 h-12 px-4 rounded-2xl border-2 border-blue-100 bg-[#f8fbff] text-sm text-[#131D4F] focus:border-[#0056B3] focus:ring-1 focus:ring-[#0056B3]"
                    >
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="disetujui">Disetujui</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-[#e1effe] text-[#131D4F]">
                        <tr>
                            <th class="px-6 py-4 text-sm font-extrabold whitespace-nowrap text-center w-16">No</th>
                            <th class="px-6 py-4 text-sm font-extrabold whitespace-nowrap">Nama Event</th>
                            <th class="px-6 py-4 text-sm font-extrabold whitespace-nowrap">ID Ruangan</th>
                            <th class="px-6 py-4 text-sm font-extrabold whitespace-nowrap">Tanggal & Waktu</th>
                            <th class="px-6 py-4 text-sm font-extrabold whitespace-nowrap">Kuota</th>
                            <th class="px-6 py-4 text-sm font-extrabold whitespace-nowrap">Status</th>
                            <th class="px-6 py-4 text-sm font-extrabold text-center whitespace-nowrap w-40">Aksi</th>
                        </tr>
                    </thead>

                    <tbody id="eventTableBody" class="divide-y divide-blue-50 text-sm text-gray-700">
                        @forelse($events as $index => $event)
                            <tr class="hover:bg-slate-50/50 transition-all">
                                <td class="px-6 py-4 text-center text-gray-400 font-medium">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold text-[#131D4F] block">{{ $event->nama_event }}</span>
                                    <span class="text-xs text-gray-400 line-clamp-1 mt-0.5">{{ $event->deskripsi }}</span>
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-600">
                                    RUANG-{{ $event->id_ruangan }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="block font-medium text-gray-800">{{ \Carbon\Carbon::parse($event->tanggal_pelaksanaan)->translatedFormat('d F Y') }}</span>
                                    <span class="text-xs text-gray-400 mt-0.5 block">{{ substr($event->waktu_mulai, 0, 5) }} - {{ substr($event->waktu_selesai, 0, 5) }} WIB</span>
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-600">
                                    {{ $event->kuota }} orang
                                </td>
                                <td class="px-6 py-4">
                                    @if($event->status === 'disetujui' || $event->status === 'approved')
                                        <span class="inline-block px-3 py-1 text-xs font-bold bg-green-100 text-green-700 rounded-full">Disetujui</span>
                                    @elseif($event->status === 'pending')
                                        <span class="inline-block px-3 py-1 text-xs font-bold bg-amber-100 text-amber-600 rounded-full">Pending</span>
                                    @else
                                        <span class="inline-block px-3 py-1 text-xs font-bold bg-red-100 text-red-600 rounded-full">Ditolak</span>
                                    @endif
                                </td>
                                
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        @if (Auth::user()->role === 'admin')
                                            
                                            <a href="{{ route('event.show', $event->id_event ?? $event->id) }}" 
                                            class="px-3 py-1.5 rounded-xl bg-gray-100 text-[#131D4F] text-xs font-bold hover:bg-gray-200 transition shadow-sm flex items-center gap-1">
                                                <i class="fa-solid fa-eye"></i> Detail
                                            </a>

                                            @if($event->status === 'pending')
                                                <form action="{{ route('event.konfirmasi', $event->id_event ?? $event->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-4 py-1.5 bg-[#0056B3] text-white text-xs font-bold rounded-xl hover:bg-[#131D4F] transition shadow-sm">
                                                        Konfirmasi
                                                    </button>
                                                </form>
                                            @endif

                                        @else
                                            
                                            <a href="{{ route('event.edit', $event->id_event ?? $event->id) }}" class="px-3 py-1.5 bg-amber-500 text-white text-xs font-bold rounded-xl hover:bg-amber-600 transition shadow-sm">
                                                Edit
                                            </a>
                                            
                                            <form action="{{ route('event.destroy', $event->id_event ?? $event->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-red-600 text-white text-xs font-bold rounded-xl hover:bg-red-700 transition shadow-sm">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-gray-400 italic font-medium">
                                    Belum ada data pengajuan event saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const searchEvent = document.getElementById('searchEvent');
        const filterStatus = document.getElementById('filterStatus');
        const eventTableBody = document.getElementById('eventTableBody');

        function filterTable() {
            const searchValue = searchEvent.value.toLowerCase();
            const statusValue = filterStatus.value.toLowerCase();
            const rows = eventTableBody.getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                if (row.cells.length < 5) continue; 

                const namaEvent = row.cells[1].textContent.toLowerCase();
                const deskripsi = row.cells[1].querySelector('span.text-xs')?.textContent.toLowerCase() || '';
                const idRuangan = row.cells[2].textContent.toLowerCase();
                const status = row.cells[5].textContent.trim().toLowerCase();

                const matchesSearch = namaEvent.includes(searchValue) || deskripsi.includes(searchValue) || idRuangan.includes(searchValue);
                const matchesStatus = statusValue === "" || status === statusValue;

                if (matchesSearch && matchesStatus) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
        }

        searchEvent.addEventListener('keyup', filterTable);
        filterStatus.addEventListener('change', filterTable);
    </script>
@endsection