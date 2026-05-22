@extends('layouts.admin')

@section('title', 'Dashboard Admin - SiEvent UNEJ')

@section('page-title', 'Dashboard Admin')

@section('content')
    <!-- Welcome Section -->
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

    <!-- Statistic Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <x-admin-stat-card
            title="Total Ruangan"
            value="{{ $totalRuangan }}"
            subtitle="Ruangan tersedia"
            icon="fa-solid fa-door-open"
            color="#0056B3"
        />

        <x-admin-stat-card
            title="Pengajuan Event"
            value="Belum"
            subtitle="Belum dikonfirmasi"
            icon="fa-solid fa-clock"
            color="#954C2E"
        />

        <x-admin-stat-card
            title="Event Disetujui"
            value="Belum"
            subtitle="Event aktif"
            icon="fa-solid fa-circle-check"
            color="#131D4F"
        />

        <x-admin-stat-card
            title="Total User"
            value="{{ $totalUser }}"
            subtitle="Mahasiswa & penyelenggara"
            icon="fa-solid fa-users"
            color="#0056B3"
        />
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Pengajuan Event -->
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

                <a href="#" class="text-sm font-bold text-[#0056B3] hover:underline">
                    Lihat Semua
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-[#e1effe] text-[#131D4F]">
                        <tr>
                            <th class="px-6 py-4 text-sm font-extrabold">Nama Event</th>
                            <th class="px-6 py-4 text-sm font-extrabold">Penyelenggara</th>
                            <th class="px-6 py-4 text-sm font-extrabold">Tanggal</th>
                            <th class="px-6 py-4 text-sm font-extrabold">Status</th>
                            <th class="px-6 py-4 text-sm font-extrabold">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-blue-50">
                        <tr class="hover:bg-blue-50/50 transition">
                            <td class="px-6 py-4 font-semibold text-[#1b3028]">
                                Seminar Teknologi Kampus
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                BEM UNEJ
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                20 Mei 2026
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">
                                    Pending
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <button class="px-4 py-2 rounded-xl bg-[#0056B3] text-white text-sm font-bold hover:bg-[#131D4F] transition">
                                    Detail
                                </button>
                            </td>
                        </tr>

                        <tr class="hover:bg-blue-50/50 transition">
                            <td class="px-6 py-4 font-semibold text-[#1b3028]">
                                Workshop UI/UX Design
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                HIMATIF
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                24 Mei 2026
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">
                                    Pending
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <button class="px-4 py-2 rounded-xl bg-[#0056B3] text-white text-sm font-bold hover:bg-[#131D4F] transition">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Event Hari Ini -->
        <div class="bg-white rounded-3xl border border-blue-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-blue-100">
                <h3 class="text-lg font-extrabold text-[#131D4F]">
                    Event Hari Ini
                </h3>
                <p class="text-sm text-gray-500 mt-1">
                    Kegiatan yang berlangsung hari ini.
                </p>
            </div>

            <div class="p-6 space-y-4">
                <div class="p-4 rounded-2xl bg-[#e1effe] border border-blue-100">
                    <p class="font-bold text-[#131D4F]">
                        Seminar AI
                    </p>
                    <p class="text-sm text-gray-600 mt-1">
                        Aula Fakultas Ilmu Komputer
                    </p>
                    <p class="text-xs text-[#0056B3] font-bold mt-2">
                        09.00 - 12.00 WIB
                    </p>
                </div>

                <div class="p-4 rounded-2xl bg-[#e1effe] border border-blue-100">
                    <p class="font-bold text-[#131D4F]">
                        Pelatihan Public Speaking
                    </p>
                    <p class="text-sm text-gray-600 mt-1">
                        Gedung Soetardjo
                    </p>
                    <p class="text-xs text-[#0056B3] font-bold mt-2">
                        13.00 - 15.00 WIB
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
