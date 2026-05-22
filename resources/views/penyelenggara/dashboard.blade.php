@extends('layouts.penyelenggara')

@section('title', 'Dashboard Penyelenggara - SiEvent UNEJ')

@section('page-title', 'Dashboard Penyelenggara')

@section('content')
    <!-- Welcome Section -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-[#0056B3] to-[#131D4F] rounded-3xl p-8 text-white shadow-lg relative overflow-hidden">
            <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full translate-x-20 -translate-y-20"></div>
            <div class="absolute right-24 bottom-0 w-32 h-32 bg-white/10 rounded-full translate-y-16"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h2 class="text-3xl font-extrabold mb-3">
                        Halo, {{ Auth::user()->nama ?? 'Penyelenggara' }} 👋
                    </h2>

                    <p class="text-white/85 max-w-2xl leading-relaxed">
                        Selamat datang di dashboard penyelenggara SiEvent UNEJ.
                        Kelola pengajuan event, export data peserta dan presensi, serta cek jadwal event Anda dengan mudah.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Penyelenggara -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <x-penyelenggara-stat-card
            title="Event Saya"
            value="6"
            subtitle="Total event yang dibuat"
            icon="fa-solid fa-calendar-days"
            color="#0056B3"
        />

        <x-penyelenggara-stat-card
            title="Menunggu Konfirmasi"
            value="2"
            subtitle="Event belum disetujui admin"
            icon="fa-solid fa-clock"
            color="#131D4F"
        />
    </div>

    <!-- Konten Utama -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Event Terbaru yang Dibuat -->
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

                <a href="#" class="text-sm font-bold text-[#0056B3] hover:underline">
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
                            <th class="px-6 py-4 text-sm font-extrabold">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-blue-50">
                        <tr class="hover:bg-blue-50/50 transition">
                            <td class="px-6 py-4 font-semibold text-[#1b3028]">
                                Seminar Teknologi Kampus
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                20 Mei 2026
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                Aula Fakultas Ilmu Komputer
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
                                24 Mei 2026
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                Gedung Soetardjo UNEJ
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                    Approved
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
                                Pelatihan Public Speaking
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                28 Mei 2026
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                Aula Utama UNEJ
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                    Rejected
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

        <!-- Jadwal Event Saya -->
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
                <div class="p-4 rounded-2xl bg-[#e1effe] border border-blue-100">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-[#0056B3] text-white flex items-center justify-center">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>

                        <div>
                            <p class="font-bold text-[#131D4F]">
                                Seminar Teknologi Kampus
                            </p>

                            <p class="text-sm text-gray-600 mt-1">
                                Aula Fakultas Ilmu Komputer
                            </p>

                            <p class="text-xs text-[#0056B3] font-bold mt-2">
                                20 Mei 2026 • 09.00 WIB
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-[#e1effe] border border-blue-100">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-[#131D4F] text-white flex items-center justify-center">
                            <i class="fa-solid fa-users"></i>
                        </div>

                        <div>
                            <p class="font-bold text-[#131D4F]">
                                Workshop UI/UX Design
                            </p>

                            <p class="text-sm text-gray-600 mt-1">
                                Gedung Soetardjo UNEJ
                            </p>

                            <p class="text-xs text-[#0056B3] font-bold mt-2">
                                24 Mei 2026 • 13.00 WIB
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-[#f8fbff] border border-dashed border-blue-200 text-center">
                    <p class="text-sm text-gray-500">
                        Jadwal event yang Anda buat akan tampil di bagian ini.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
