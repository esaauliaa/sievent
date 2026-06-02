@extends('layouts.' . Auth::user()->role)

@section('title', 'Tambah Event - SiEvent UNEJ')

@section('page-title', 'Tambah Event')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="mb-8">
            <div class="bg-gradient-to-r from-[#0056B3] to-[#131D4F] rounded-3xl p-8 text-white shadow-lg relative overflow-hidden">
                <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full translate-x-20 -translate-y-20"></div>
                <div class="absolute right-24 bottom-0 w-32 h-32 bg-white/10 rounded-full translate-y-16"></div>

                <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <h2 class="text-3xl font-extrabold mb-3">
                            Tambah Event
                        </h2>

                        <p class="text-white/85 max-w-2xl leading-relaxed">
                            Tambahkan data event yang dapat digunakan untuk kegiatan atau event kampus.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-blue-100 shadow-sm overflow-hidden max-w-7xl mx-auto">
            <div class="px-6 py-5 border-b border-blue-100">
                <h3 class="text-lg font-extrabold text-[#131D4F]">
                    Form Tambah Event
                </h3>
                <p class="text-sm text-gray-500 mt-1">
                    Isi data event dengan benar.
                </p>
            </div>

            <form action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf

                <div class="space-y-2">
                    <label for="nama_event" class="text-sm font-bold text-[#131D4F]">Nama Event</label>
                    <div class="relative">
                        <i class="fa-solid fa-file-signature absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input
                            id="nama_event"
                            name="nama_event"
                            type="text"
                            placeholder="Contoh: Seminar Teknologi Masa Depan"
                            class="w-full h-12 pl-11 pr-4 rounded-2xl border-2 border-blue-100 bg-[#f8fbff] text-sm text-[#131D4F] focus:border-[#0056B3] focus:ring-1 focus:ring-[#0056B3]"
                            required
                        >
                    </div>
                </div>

                <!-- Deskripsi Singkat -->
                <div class="space-y-2">
                    <label for="deskripsi" class="text-sm font-bold text-[#131D4F]">Deskripsi Singkat</label>
                    <div class="relative">
                        <textarea
                            id="deskripsi"
                            name="deskripsi"
                            rows="3"
                            placeholder="Contoh: Kegiatan sosialisasi dan pengembangan skill pweb mahasiswa..."
                            class="w-full pl-11 pr-4 py-3 rounded-2xl border-2 border-blue-100 bg-[#f8fbff] text-sm text-[#131D4F] focus:border-[#0056B3] focus:ring-1 focus:ring-[#0056B3] placeholder-gray-400"
                            required
                        ></textarea>
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="id_ruangan" class="text-sm font-bold text-[#131D4F]">Pilihan Lokasi Ruangan</label>
                    <div class="relative">
                        <i class="fa-solid fa-building absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <select
                            id="id_ruangan"
                            name="id_ruangan"
                            class="w-full h-12 pl-11 pr-4 rounded-2xl border-2 border-blue-100 bg-[#f8fbff] text-sm text-[#131D4F] focus:border-[#0056B3] focus:ring-1 focus:ring-[#0056B3]"
                            required
                        >
                            <option value="" disabled selected>Pilih lokasi ruangan</option>
                            @foreach($ruangans as $ruangan)
                                <option value="{{ $ruangan->id_ruangan }}">{{ $ruangan->nama_ruangan }} (Kapasitas: {{ $ruangan->kapasitas }} orang)</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-2">
                        <label for="tanggal_pelaksanaan" class="text-sm font-bold text-[#131D4F]">Tanggal Pelaksanaan</label>
                        <div class="relative">
                            <i class="fa-solid fa-calendar-days absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input
                                id="tanggal_pelaksanaan"
                                name="tanggal_pelaksanaan"
                                type="date"
                                class="w-full h-12 pl-11 pr-4 rounded-2xl border-2 border-blue-100 bg-[#f8fbff] text-sm text-[#131D4F] focus:border-[#0056B3] focus:ring-1 focus:ring-[#0056B3]"
                                required
                            >
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="waktu_mulai" class="text-sm font-bold text-[#131D4F]">Waktu Mulai</label>
                        <div class="relative">
                            <i class="fa-solid fa-clock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input
                                id="waktu_mulai"
                                name="waktu_mulai"
                                type="time"
                                class="w-full h-12 pl-11 pr-4 rounded-2xl border-2 border-blue-100 bg-[#f8fbff] text-sm text-[#131D4F] focus:border-[#0056B3] focus:ring-1 focus:ring-[#0056B3]"
                                required
                            >
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="waktu_selesai" class="text-sm font-bold text-[#131D4F]">Waktu Selesai</label>
                        <div class="relative">
                            <i class="fa-solid fa-clock-rotate-left absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input
                                id="waktu_selesai"
                                name="waktu_selesai"
                                type="time"
                                class="w-full h-12 pl-11 pr-4 rounded-2xl border-2 border-blue-100 bg-[#f8fbff] text-sm text-[#131D4F] focus:border-[#0056B3] focus:ring-1 focus:ring-[#0056B3]"
                                required
                            >
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-2">
                        <label for="kuota" class="text-sm font-bold text-[#131D4F]">Kapasitas Kuota</label>
                        <div class="relative">
                            <i class="fa-solid fa-users absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input
                                id="kuota"
                                name="kuota"
                                type="number"
                                min="1"
                                placeholder="Contoh: 100"
                                class="w-full h-12 pl-11 pr-4 rounded-2xl border-2 border-blue-100 bg-[#f8fbff] text-sm text-[#131D4F] focus:border-[#0056B3] focus:ring-1 focus:ring-[#0056B3]"
                                required
                            >
                        </div>
                    </div>

                    <!-- Upload Poster Event -->
                    <div class="space-y-2">
                        <label for="poster" class="text-sm font-bold text-[#131D4F]">Upload Poster Event</label>
                        <div class="relative">
                            <i class="fa-solid fa-image absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input
                                id="poster"
                                name="poster" 
                                type="file"
                                accept="image/*"
                                class="w-full h-12 pl-11 pr-4 rounded-2xl border-2 @error('poster') border-red-300 bg-red-50/30 @else border-blue-100 bg-[#f8fbff] @enderror text-sm text-gray-500 focus:border-[#0056B3] focus:ring-1 focus:ring-[#0056B3] cursor-pointer flex items-center leading-none py-2"
                            >
                        </div>
                        <p class="text-[11px] text-gray-400 font-medium pl-1">Format: JPG, PNG, WEBP (Maks. 5MB)</p>
                        @error('poster')
                            <p class="text-xs text-red-600 font-bold mt-1 pl-1 flex items-center gap-1">
                                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="proposal" class="text-sm font-bold text-[#131D4F]">Upload Proposal (PDF)</label>
                        <div class="relative">
                            <i class="fa-solid fa-file-pdf absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input
                                id="proposal"
                                name="proposal" 
                                type="file"
                                accept=".pdf"
                                class="w-full h-12 pl-11 pr-4 rounded-2xl border-2 @error('proposal') border-red-300 bg-red-50/30 @else border-blue-100 bg-[#f8fbff] @enderror text-sm text-gray-500 focus:border-[#0056B3] focus:ring-1 focus:ring-[#0056B3] cursor-pointer flex items-center leading-none py-2"
                            >
                        </div>
                        <p class="text-[11px] text-gray-400 font-medium pl-1">Format: Dokumen PDF (Maks. 20MB)</p>
                        @error('proposal')
                            <p class="text-xs text-red-600 font-bold mt-1 pl-1 flex items-center gap-1">
                                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                <div class="pt-4 border-t border-blue-50 flex flex-col sm:flex-row justify-between gap-4">
                    <a
                        href="{{ route('event.index') }}"
                        class="px-6 h-12 inline-flex items-center justify-center rounded-2xl bg-gray-100 text-gray-700 hover:bg-gray-200 transition font-bold text-sm shadow-sm"
                    >
                        Kembali
                    </a>
                    <button
                        type="submit"
                        class="px-6 h-12 inline-flex items-center justify-center rounded-2xl bg-[#0056B3] text-white hover:bg-[#004494] transition font-bold text-sm shadow-md gap-2"
                    >
                        <i class="fa-solid fa-floppy-disk"></i>
                        Ajukan Event
                    </button>
                </div>

            </form>
            </div>
    </div>
@endsection