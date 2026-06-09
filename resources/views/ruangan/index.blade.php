@extends('layouts.' . Auth::user()->role)

@section('title', 'Data Ruangan - SiEvent UNEJ')

@section('page-title', 'Data Ruangan')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-[#0056B3] to-[#131D4F] rounded-3xl p-8 text-white shadow-lg relative overflow-hidden">
                <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full translate-x-20 -translate-y-20"></div>
                <div class="absolute right-24 bottom-0 w-32 h-32 bg-white/10 rounded-full translate-y-16"></div>

                <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <h2 class="text-3xl font-extrabold mb-3">
                            Data Ruangan
                        </h2>

                        <p class="text-white/85 max-w-2xl leading-relaxed">
                            Halaman ini digunakan untuk melihat informasi ruangan
                            untuk seluruh event atau kegiatan Universitas Jember.
                        </p>
                    </div>

                    @if (Auth::user()->role === 'admin')
                        <a
                            href="{{ route('ruangan.create') }}"
                            class="px-6 py-3 rounded-2xl bg-white text-[#0056B3] hover:bg-[#e1effe] transition font-bold shadow-md whitespace-nowrap"
                        >
                            <i class="fa-solid fa-plus mr-2"></i>
                            Tambah Ruangan
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Alert Sukses -->
        @if (session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-green-100 text-green-700 font-bold">
                {{ session('success') }}
            </div>
        @endif

        <!-- Card Table -->
        <div class="bg-white rounded-3xl border border-blue-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-blue-100 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
                <div>
                    <h3 class="text-lg font-extrabold text-[#131D4F]">
                        Daftar Ruangan
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Menampilkan seluruh data ruangan yang ada di Universitas Jember.
                    </p>
                </div>

                <!-- Search dan Filter AJAX -->
                <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                    <div class="relative w-full sm:w-72">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>

                        <input
                            id="searchRuangan"
                            type="text"
                            placeholder="Cari ruangan..."
                            class="w-full h-12 pl-11 pr-4 rounded-2xl border-2 border-blue-100 bg-[#f8fbff] text-sm text-[#131D4F] focus:border-[#0056B3] focus:ring-1 focus:ring-[#0056B3]"
                        >
                    </div>

                    <select
                        id="filterStatus"
                        class="w-full sm:w-56 h-12 px-4 rounded-2xl border-2 border-blue-100 bg-[#f8fbff] text-sm text-[#131D4F] focus:border-[#0056B3] focus:ring-1 focus:ring-[#0056B3]"
                    >
                        <option value="">Semua Status</option>
                        <option value="tersedia">Tersedia</option>
                        <option value="tidak_tersedia">Tidak Tersedia</option>
                    </select>
                </div>
            </div>

            <!-- Loading AJAX -->
            <div
                id="loadingAjax"
                class="hidden px-6 py-3 text-sm text-[#0056B3] font-semibold bg-blue-50 border-b border-blue-100"
            >
                <i class="fa-solid fa-spinner fa-spin mr-2"></i>
                Memuat data ruangan...
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-[#e1effe] text-[#131D4F]">
                        <tr>
                            <th class="px-6 py-4 text-sm font-extrabold whitespace-nowrap">
                                No
                            </th>

                            <th class="px-6 py-4 text-sm font-extrabold whitespace-nowrap">
                                Nama Ruangan
                            </th>

                            <th class="px-6 py-4 text-sm font-extrabold whitespace-nowrap">
                                Lokasi
                            </th>

                            <th class="px-6 py-4 text-sm font-extrabold whitespace-nowrap">
                                Kapasitas
                            </th>

                            <th class="px-6 py-4 text-sm font-extrabold whitespace-nowrap">
                                Status
                            </th>

                            @if (Auth::user()->role === 'admin')
                                <th class="px-6 py-4 text-sm font-extrabold text-center whitespace-nowrap">
                                    Aksi
                                </th>
                            @endif
                        </tr>
                    </thead>

                    <tbody id="ruanganTableBody" class="divide-y divide-blue-50">
                        @include('ruangan.partials.table-body', ['ruangans' => $ruangans])
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const searchRuangan = document.getElementById('searchRuangan');
        const filterStatus = document.getElementById('filterStatus');
        const ruanganTableBody = document.getElementById('ruanganTableBody');
        const loadingAjax = document.getElementById('loadingAjax');

        let searchTimer = null;

        function fetchRuangan() {
            const search = searchRuangan.value;
            const status = filterStatus.value;

            const url = new URL("{{ route('ruangan.index') }}");
            url.searchParams.append('search', search);
            url.searchParams.append('status', status);

            loadingAjax.classList.remove('hidden');

            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                ruanganTableBody.innerHTML = html;
            })
            .catch(error => {
                console.error('Gagal mengambil data ruangan:', error);
            })
            .finally(() => {
                loadingAjax.classList.add('hidden');
            });
        }

        searchRuangan.addEventListener('keyup', function () {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {
                fetchRuangan();
            }, 400);
        });

        filterStatus.addEventListener('change', function () {
            fetchRuangan();
        });
    </script>
@endsection
