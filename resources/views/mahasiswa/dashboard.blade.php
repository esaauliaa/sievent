@extends('layouts.mahasiswa')

@section('title', 'Dashboard Mahasiswa - SiEvent UNEJ')

@section('page-title', 'Dashboard Mahasiswa')

@section('content')
    <!-- Welcome Section -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-[#0056B3] to-[#131D4F] rounded-3xl p-8 text-white shadow-lg relative overflow-hidden">
            <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full translate-x-20 -translate-y-20"></div>
            <div class="absolute right-24 bottom-0 w-32 h-32 bg-white/10 rounded-full translate-y-16"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h2 class="text-3xl font-extrabold mb-3">
                        Halo, {{ Auth::user()->nama ?? 'Mahasiswa' }} 👋
                    </h2>

                    <p class="text-white/85 max-w-2xl leading-relaxed">
                        Selamat datang di SiEvent UNEJ. Temukan daftar kegiatan event kampus,
                        dan pantau jadwal event yang Anda ikuti dengan mudah.
                    </p>
                </div>

                <a
                    href="#"
                    class="px-6 py-3 rounded-2xl bg-white text-[#0056B3] hover:bg-[#e1effe] transition font-bold shadow-md"
                >
                    <i class="fa-solid fa-calendar-plus mr-2"></i>
                    Cari Event
                </a>
            </div>
        </div>
    </div>

    <!-- Statistik Mahasiswa -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-6 mb-8">
        <x-mahasiswa-stat-card
            title="Event Tersedia"
            value="18"
            subtitle="Event kampus yang dapat diikuti"
            icon="fa-solid fa-calendar-days"
            color="#0056B3"
        />

        <x-mahasiswa-stat-card
            title="Event yang Diikuti"
            value="4"
            subtitle="Event yang sudah Anda daftar"
            icon="fa-solid fa-user-check"
            color="#131D4F"
        />
    </div>

    <!-- Konten Utama -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Event Terbaru -->
        <div class="xl:col-span-2 bg-white rounded-3xl border border-blue-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-blue-100 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-extrabold text-[#131D4F]">
                        Event Terbaru
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Daftar event terbaru yang dapat Anda ikuti.
                    </p>
                </div>

                <a href="#" class="text-sm font-bold text-[#0056B3] hover:underline">
                    Lihat Semua
                </a>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Card Event 1 -->
                <div class="rounded-3xl border border-blue-100 overflow-hidden hover:shadow-lg transition bg-[#f8fbff]">
                    <div class="h-36 bg-gradient-to-r from-[#0056B3] to-[#131D4F] flex items-center justify-center text-white">
                        <i class="fa-solid fa-calendar-days text-5xl"></i>
                    </div>

                    <div class="p-5">
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                            Dibuka
                        </span>

                        <h4 class="text-lg font-extrabold text-[#131D4F] mt-3">
                            Seminar Teknologi Kampus
                        </h4>

                        <p class="text-sm text-gray-500 mt-2">
                            Aula Fakultas Ilmu Komputer
                        </p>

                        <p class="text-sm text-[#0056B3] font-bold mt-3">
                            20 Mei 2026 • 09.00 WIB
                        </p>

                        <button class="mt-4 w-full py-3 rounded-2xl bg-[#0056B3] text-white font-bold hover:bg-[#131D4F] transition">
                            Daftar Event
                        </button>
                    </div>
                </div>

                <!-- Card Event 2 -->
                <div class="rounded-3xl border border-blue-100 overflow-hidden hover:shadow-lg transition bg-[#f8fbff]">
                    <div class="h-36 bg-gradient-to-r from-[#0056B3] to-[#131D4F] flex items-center justify-center text-white">
                        <i class="fa-solid fa-microphone text-5xl"></i>
                    </div>

                    <div class="p-5">
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                            Dibuka
                        </span>

                        <h4 class="text-lg font-extrabold text-[#131D4F] mt-3">
                            Pelatihan Public Speaking
                        </h4>

                        <p class="text-sm text-gray-500 mt-2">
                            Gedung Soetardjo UNEJ
                        </p>

                        <p class="text-sm text-[#0056B3] font-bold mt-3">
                            24 Mei 2026 • 13.00 WIB
                        </p>

                        <button class="mt-4 w-full py-3 rounded-2xl bg-[#0056B3] text-white font-bold hover:bg-[#131D4F] transition">
                            Daftar Event
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jadwal Event Saya -->
        <div class="bg-white rounded-3xl border border-blue-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-blue-100">
                <h3 class="text-lg font-extrabold text-[#131D4F]">
                    Jadwal Event Saya
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    Event yang sudah Anda daftar.
                </p>
            </div>

            <div class="p-6 space-y-4">
                <!-- Jadwal 1 -->
                <div class="p-4 rounded-2xl bg-[#e1effe] border border-blue-100">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-[#0056B3] text-white flex items-center justify-center">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>

                        <div>
                            <p class="font-bold text-[#131D4F]">
                                Seminar AI
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

                <!-- Jadwal 2 -->
                <div class="p-4 rounded-2xl bg-[#e1effe] border border-blue-100">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-[#131D4F] text-white flex items-center justify-center">
                            <i class="fa-solid fa-users"></i>
                        </div>

                        <div>
                            <p class="font-bold text-[#131D4F]">
                                Pelatihan Public Speaking
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
                        Event yang Anda ikuti akan tampil di bagian ini.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
