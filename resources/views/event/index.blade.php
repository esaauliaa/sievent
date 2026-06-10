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

                    @if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'mahasiswa')
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

                    @if (Auth::user()->role !== 'mahasiswa')
                        <select
                            id="filterStatus"
                            class="w-full sm:w-56 h-12 px-4 rounded-2xl border-2 border-blue-100 bg-[#f8fbff] text-sm text-[#131D4F] focus:border-[#0056B3] focus:ring-1 focus:ring-[#0056B3]"
                        >
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="disetujui">Disetujui</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    @endif
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-[#e1effe] text-[#131D4F]">
                        <tr>
                            <th class="px-6 py-4 text-sm font-extrabold whitespace-nowrap text-center w-16">No</th>
                            <th class="px-6 py-4 text-sm font-extrabold whitespace-nowrap">Nama Event</th>
                            <th class="px-6 py-4 text-sm font-extrabold whitespace-nowrap">Nama Ruangan</th>
                            <th class="px-6 py-4 text-sm font-extrabold whitespace-nowrap">Tanggal & Waktu</th>
                            
                            @if (Auth::user()->role !== 'mahasiswa')
                                <th class="px-6 py-4 text-sm font-extrabold whitespace-nowrap">Kuota</th>
                                <th class="px-6 py-4 text-sm font-extrabold whitespace-nowrap">Status</th>
                            @endif

                            <th class="px-6 py-4 text-sm font-extrabold text-center whitespace-nowrap w-56">Aksi</th>
                        </tr>
                    </thead>

                    <tbody id="eventTableBody" class="divide-y divide-blue-50 text-sm text-gray-700">
                        @forelse($events as $index => $event)
                            @php
                                $isExpired = $event->is_expired;
                                $alreadyRegistered = in_array($event->id_event ?? $event->id, $myEventIds ?? []);
                            @endphp
                            <tr class="transition-all {{ $isExpired ? 'bg-gray-50 opacity-90' : 'hover:bg-slate-50/50' }}">
                                <td class="px-6 py-4 text-center text-gray-400 font-medium">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 {{ $isExpired ? 'text-gray-500' : '' }}">
                                    <span class="font-bold {{ $isExpired ? 'text-gray-500' : 'text-[#131D4F]' }} block">{{ $event->nama_event }}</span>
                                    <span class="text-xs {{ $isExpired ? 'text-gray-400' : 'text-gray-400' }} line-clamp-1 mt-0.5">{{ $event->deskripsi }}</span>
                                </td>
                                <td class="px-6 py-4 font-medium {{ $isExpired ? 'text-gray-500' : 'text-gray-600' }}">
                                    {{ $event->ruangan->nama_ruangan ?? 'Ruangan Tidak Ditemukan' }}
                                </td>
                                <td class="px-6 py-4 {{ $isExpired ? 'text-gray-500' : '' }}">
                                    <span class="block font-medium {{ $isExpired ? 'text-gray-500' : 'text-gray-800' }}">{{ \Carbon\Carbon::parse($event->tanggal_pelaksanaan)->translatedFormat('d F Y') }}</span>
                                    <span class="text-xs {{ $isExpired ? 'text-gray-500' : 'text-gray-400' }} mt-0.5 block">{{ substr($event->waktu_mulai, 0, 5) }} - {{ substr($event->waktu_selesai, 0, 5) }} WIB</span>
                                </td>

                                @if (Auth::user()->role !== 'mahasiswa')
                                    <td class="px-6 py-4 font-semibold {{ $isExpired ? 'text-gray-500' : 'text-gray-600' }}">
                                        {{ $event->kuota }} orang
                                    </td>
                                    <td class="px-6 py-4 {{ $isExpired ? 'text-gray-500' : '' }}">
                                        @if($isExpired)
                                            <span class="inline-block px-3 py-1 text-xs font-bold bg-gray-100 text-gray-500 rounded-full">Selesai</span>
                                        @elseif($event->status === 'disetujui' || $event->status === 'approved')
                                            <span class="inline-block px-3 py-1 text-xs font-bold bg-green-100 text-green-700 rounded-full">Disetujui</span>
                                        @elseif($event->status === 'pending')
                                            <span class="inline-block px-3 py-1 text-xs font-bold bg-amber-100 text-amber-700 rounded-full">Pending</span>
                                        @else
                                            <span class="inline-block px-3 py-1 text-xs font-bold bg-red-100 text-red-600 rounded-full">Ditolak</span>
                                        @endif
                                    </td>
                                @endif
                                
                                <td class="px-6 py-4 {{ $isExpired ? 'text-gray-500' : '' }}">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('event.show', $event->id_event ?? $event->id) }}" 
                                           class="px-3 py-1.5 rounded-xl bg-gray-100 text-xs font-bold {{ $isExpired ? 'text-gray-500 hover:bg-gray-100' : 'text-[#131D4F] hover:bg-gray-200' }} transition shadow-sm flex items-center gap-1">
                                            <i class="fa-solid fa-eye"></i> Detail
                                        </a>

                                        @if (Auth::user()->role === 'admin')
                                            @if($event->status === 'pending')
                                                <form action="{{ route('event.konfirmasi', $event->id_event ?? $event->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin memberikan perizinan dan menyetujui kegiatan ini?')">
                                                    @csrf
                                                    <button type="submit" class="px-4 py-1.5 bg-[#0056B3] text-white text-xs font-bold rounded-xl hover:bg-[#131D4F] transition shadow-sm">
                                                        Konfirmasi
                                                    </button>
                                                </form>
                                            @elseif($event->status === 'disetujui' || $event->status === 'approved')
                                                <a href="{{ route('presensi.show', $event->id_event ?? $event->id) }}"
                                                   class="px-3 py-1.5 rounded-xl bg-green-600 text-white text-xs font-bold hover:bg-green-700 transition shadow-sm flex items-center gap-1">
                                                    <i class="fa-solid fa-clipboard-check"></i> Presensi
                                                </a>
                                            @endif
                                        @elseif (Auth::user()->role === 'mahasiswa')
                                            @if ($isExpired)
                                                <button type="button" class="px-3 py-1.5 bg-gray-300 text-gray-500 text-xs font-bold rounded-xl cursor-not-allowed flex items-center gap-1 shadow-sm" disabled>
                                                    <i class="fa-solid fa-ban"></i> Event Selesai
                                                </button>
                                            @elseif ($alreadyRegistered)
                                                <button type="button" class="px-3 py-1.5 bg-gray-300 text-gray-500 text-xs font-bold rounded-xl cursor-not-allowed flex items-center gap-1 shadow-sm" disabled>
                                                    <i class="fa-solid fa-check"></i> Sudah Terdaftar
                                                </button>
                                            @else
                                                <form action="{{ route('event.daftar', $event->id_event ?? $event->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin mendaftar ke dalam kegiatan event ini?')">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1.5 bg-[#0056B3] text-white text-xs font-bold rounded-xl hover:bg-[#131D4F] transition shadow-sm flex items-center gap-1">
                                                        <i class="fa-solid fa-ticket"></i> Daftar Event
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                                @if($event->status === 'disetujui' || $event->status === 'approved')
                                                    <button type="button" class="px-3 py-1.5 bg-gray-300 text-gray-500 text-xs font-bold rounded-xl cursor-not-allowed" disabled>
                                                        Edit
                                                    </button>
                                                @else
                                                    <a href="{{ route('event.edit', $event->id_event ?? $event->id) }}" class="px-3 py-1.5 bg-amber-500 text-white text-xs font-bold rounded-xl hover:bg-amber-600 transition shadow-sm">
                                                        Edit
                                                    </a>
                                                @endif

                                                @if($event->status === 'disetujui' || $event->status === 'approved')
                                                    <a href="{{ route('presensi.show', $event->id_event ?? $event->id) }}"
                                                       class="px-3 py-1.5 bg-green-600 text-white text-xs font-bold rounded-xl hover:bg-green-700 transition shadow-sm flex items-center gap-1">
                                                        <i class="fa-solid fa-clipboard-check"></i> Presensi
                                                    </a>
                                                @endif
                                                
                                                @if($event->status === 'disetujui' || $event->status === 'approved')
                                                    <button type="button" class="px-3 py-1.5 bg-gray-100 text-gray-400 border border-gray-200 rounded-xl font-bold text-xs cursor-not-allowed" disabled>
                                                        Hapus
                                                    </button>
                                                @else
                                                    <form action="{{ route('event.destroy', $event->id_event ?? $event->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-3 py-1.5 bg-red-600 text-white text-xs font-bold rounded-xl hover:bg-red-700 transition shadow-sm">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ Auth::user()->role === 'mahasiswa' ? 5 : 7 }}" class="px-6 py-10 text-center text-gray-400 italic font-medium">
                                    Belum ada data event yang tersedia saat ini.
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
        const userRole = "{{ Auth::user()->role }}";

        function filterTable() {
            const searchValue = searchEvent.value.toLowerCase();
            const statusValue = filterStatus ? filterStatus.value.toLowerCase() : "";
            const rows = eventTableBody.getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                if (row.cells.length < 4) continue; 

                const namaEvent = row.cells[1].textContent.toLowerCase();
                const deskripsi = row.cells[1].querySelector('span.text-xs')?.textContent.toLowerCase() || '';
                const namaRuangan = row.cells[2].textContent.toLowerCase();

                const matchesSearch = namaEvent.includes(searchValue) || deskripsi.includes(searchValue) || namaRuangan.includes(searchValue);
                
                let matchesStatus = false;
                if (userRole === 'mahasiswa' || statusValue === "") {
                    matchesStatus = true;
                } else {
                    const status = row.cells[5].textContent.trim().toLowerCase();
                    if (statusValue === "disetujui" && (status === "disetujui" || status === "approved" || status === "selesai")) {
                        matchesStatus = true;
                    } else if (statusValue === "pending" && status === "pending") {
                        matchesStatus = true;
                    } else if (statusValue === "ditolak" && status === "ditolak") {
                        matchesStatus = true;
                    }
                }

                if (matchesSearch && matchesStatus) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
        }

        searchEvent.addEventListener('keyup', filterTable);
        if (filterStatus) {
            filterStatus.addEventListener('change', filterTable);
        }
    </script>
@endsection
