@extends('layouts.mahasiswa')

@section('title', 'Dashboard Mahasiswa - SiEvent UNEJ')

@section('page-title', 'Dashboard Mahasiswa')

@section('content')
    <div class="mb-8">
        <div class="bg-gradient-to-r from-[#0056B3] to-[#131D4F] rounded-3xl p-8 text-white shadow-lg relative overflow-hidden">
            <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full translate-x-20 -translate-y-20"></div>
            <div class="absolute right-24 bottom-0 w-32 h-32 bg-white/10 rounded-full translate-y-16"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h2 class="text-3xl font-extrabold mb-3">
                        Halo, {{ Auth::user()->name ?? 'Mahasiswa' }} 👋
                    </h2>

                    <p class="text-white/85 max-w-2xl leading-relaxed">
                        Selamat datang di SiEvent UNEJ. Temukan daftar kegiatan event kampus,
                        dan pantau jadwal event yang Anda ikuti dengan mudah.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a
                        href="{{ route('event.index') }}"
                        class="px-6 py-3 rounded-2xl bg-white text-[#0056B3] hover:bg-[#e1effe] transition font-bold shadow-md inline-flex items-center justify-center"
                    >
                        <i class="fa-solid fa-calendar-plus mr-2"></i>
                        Cari Event
                    </a>

                    <a
                        href="{{ route('mahasiswa.presensi') }}"
                        class="px-6 py-3 rounded-2xl bg-white/10 text-white hover:bg-white/20 transition font-bold shadow-md inline-flex items-center justify-center border border-white/20"
                    >
                        <i class="fa-solid fa-clipboard-check mr-2"></i>
                        Kehadiran Saya
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <x-mahasiswa-stat-card
            title="Event Tersedia"
            value="{{ $totalEventTersedia ?? 0 }}"
            subtitle="Event kampus aktif yang dapat diikuti"
            icon="fa-solid fa-calendar-days"
            color="#0056B3"
        />

        <x-mahasiswa-stat-card
            title="Event yang Diikuti"
            value="{{ $eventsDiikutiCount ?? 0 }}"
            subtitle="Event yang sudah Anda daftar"
            icon="fa-solid fa-user-check"
            color="#131D4F"
        />
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 bg-white rounded-3xl border border-blue-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-blue-100 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-extrabold text-[#131D4F]">
                        Event Terbaru
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Daftar kegiatan kampus terverifikasi yang dapat Anda ikuti.
                    </p>
                </div>

                <a href="{{ route('event.index') }}" class="text-sm font-bold text-[#0056B3] hover:underline">
                    Lihat Semua
                </a>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                @forelse($eventsAktif as $item)
                    <div class="rounded-3xl border border-blue-100 overflow-hidden hover:shadow-lg transition flex flex-col justify-between bg-[#f8fbff]">
                        <div>
                            <div class="h-36 bg-gradient-to-r from-[#0056B3] to-[#131D4F] flex items-center justify-center text-white relative">
                                @if($item->poster)
                                    <img src="{{ asset('storage/' . $item->poster) }}" alt="Poster {{ $item->nama_event }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fa-solid fa-calendar-days text-5xl"></i>
                                @endif
                            </div>

                            <div class="p-5">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                    Dibuka
                                </span>

                                <h4 class="text-lg font-extrabold text-[#131D4F] mt-3 line-clamp-2">
                                    {{ $item->nama_event }}
                                </h4>

                                <p class="text-sm text-gray-500 mt-2 flex items-center gap-1">
                                    <i class="fa-solid fa-location-dot text-gray-400"></i>
                                    {{ $item->ruangan->nama_ruangan ?? 'Ruangan Tidak Ditemukan' }}
                                </p>

                                <p class="text-sm text-[#0056B3] font-bold mt-3">
                                    {{ \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->translatedFormat('d F Y') }} • {{ substr($item->waktu_mulai, 0, 5) }} WIB
                                </p>
                            </div>
                        </div>

                        <div class="px-5 pb-5">
                            <a href="{{ route('event.show', $item->id_event) }}" class="block text-center w-full py-3 rounded-2xl bg-[#0056B3] text-white font-bold hover:bg-[#131D4F] transition">
                                Detail Event
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 py-10 text-center text-gray-400 italic font-medium">
                        Saat ini belum ada data event kampus terbaru yang tersedia.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-blue-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-blue-100">
                <h3 class="text-lg font-extrabold text-[#131D4F]">
                    Jadwal Event Saya
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    Event kegiatan yang sudah Anda daftarkan.
                </p>
            </div>

            <div class="p-6 space-y-4">
                @if(isset($myEvents) && count($myEvents) > 0)
                    @foreach($myEvents as $myEvent)
                        <div class="p-4 rounded-2xl bg-[#e1effe] border border-blue-100">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-xl bg-[#0056B3] text-white flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-calendar-check"></i>
                                </div>

                                <div>
                                    <p class="font-bold text-[#131D4F] line-clamp-1">
                                        {{ $myEvent->nama_event }}
                                    </p>

                                    <p class="text-sm text-gray-600 mt-1 line-clamp-1">
                                        {{ $myEvent->ruangan->nama_ruangan ?? 'Ruangan' }}
                                    </p>

                                    <p class="text-xs text-[#0056B3] font-bold mt-2">
                                        {{ \Carbon\Carbon::parse($myEvent->tanggal_pelaksanaan)->translatedFormat('d M Y') }} • {{ substr($myEvent->waktu_mulai, 0, 5) }} WIB
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                <div class="p-4 rounded-2xl bg-[#f8fbff] border border-dashed border-blue-200 text-center">
                    <p class="text-sm text-gray-500">
                        Pantau terus halaman ini untuk pembaruan jadwal event Anda.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
