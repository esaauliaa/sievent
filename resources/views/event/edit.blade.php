@extends('layouts.' . Auth::user()->role)

@section('title', 'Edit Event - SiEvent UNEJ')

@section('page-title', 'Edit Event')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        
        <div class="mb-8">
            <div class="bg-gradient-to-r from-[#0056B3] to-[#131D4F] rounded-3xl p-8 text-white shadow-lg relative overflow-hidden">
                <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full translate-x-20 -translate-y-20"></div>
                <div class="absolute right-24 bottom-0 w-32 h-32 bg-white/10 rounded-full translate-y-16"></div>

                <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-white/20 text-white mb-3 backdrop-blur-sm">
                            <i class="fa-solid fa-pen-to-square mr-1"></i> Mode Perubahan Data
                        </span>
                        <h2 class="text-3xl font-extrabold mb-2">
                            Edit Data Informasi Event
                        </h2>
                        <p class="text-white/85 max-w-xl leading-relaxed text-sm">
                            Ubah konfigurasi detail informasi event yang ingin Anda perbaiki di bawah ini.
                        </p>
                    </div>

                    <a href="{{ route('event.index') }}" 
                       class="px-5 py-3 rounded-2xl bg-white/10 text-white hover:bg-white/20 transition font-bold shadow-md border border-white/20 text-center whitespace-nowrap text-sm backdrop-blur-sm">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Batal
                    </a>
                </div>
            </div>
        </div>

        @if (session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-red-100 text-red-700 font-bold">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white p-8 rounded-3xl border border-blue-100 shadow-sm">
            <div class="mb-6 border-b border-gray-100 pb-3">
                <h3 class="text-lg font-bold text-[#131D4F]">Formulir Pembaruan Data</h3>
                <p class="text-xs text-gray-400">Pastikan seluruh data waktu operasional dan kuota diisi dengan benar.</p>
            </div>

            <form action="{{ route('event.update', $event->id_event ?? $event->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5 text-sm text-gray-700">
                @csrf
                @method('PUT')

                <div class="space-y-1.5">
                    <label class="block font-bold text-[#131D4F]">Nama Event / Kegiatan</label>
                    <input 
                        type="text" 
                        name="nama_event" 
                        value="{{ old('nama_event', $event->nama_event) }}" 
                        required 
                        class="w-full border-2 border-blue-100 rounded-2xl p-3 text-sm focus:border-[#0056B3] focus:ring-1 focus:ring-[#0056B3] bg-[#f8fbff]"
                    >
                    @error('nama_event')
                        <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block font-bold text-[#131D4F]">Deskripsi Singkat</label>
                    <textarea 
                        name="deskripsi" 
                        rows="3" 
                        required 
                        class="w-full border-2 border-blue-100 rounded-2xl p-3 text-sm focus:border-[#0056B3] focus:ring-1 focus:ring-[#0056B3] bg-[#f8fbff]"
                    >{{ old('deskripsi', $event->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <label class="block font-bold text-[#131D4F]">Pilih Ruangan Kampus</label>
                        <select 
                            name="id_ruangan" 
                            required 
                            class="w-full border-2 border-blue-100 rounded-2xl p-3 text-sm focus:border-[#0056B3] focus:ring-1 focus:ring-[#0056B3] bg-[#f8fbff]"
                        >
                            @foreach($ruangans as $ruangan)
                                <option value="{{ $ruangan->id_ruangan }}" {{ old('id_ruangan', $event->id_ruangan) == $ruangan->id_ruangan ? 'selected' : '' }}>
                                    {{ $ruangan->nama_ruangan }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_ruangan')
                            <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="block font-bold text-[#131D4F]">Kuota Maksimal Peserta</label>
                        <input 
                            type="number" 
                            name="kuota" 
                            value="{{ old('kuota', $event->kuota) }}" 
                            required 
                            class="w-full border-2 border-blue-100 rounded-2xl p-3 text-sm focus:border-[#0056B3] focus:ring-1 focus:ring-[#0056B3] bg-[#f8fbff]"
                        >
                        @error('kuota')
                            <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="space-y-1.5">
                        <label class="block font-bold text-[#131D4F]">Tanggal Pelaksanaan</label>
                        <input 
                            type="date" 
                            name="tanggal_pelaksanaan" 
                            value="{{ old('tanggal_pelaksanaan', $event->tanggal_pelaksanaan) }}" 
                            required 
                            class="w-full border-2 border-blue-100 rounded-2xl p-3 text-sm focus:border-[#0056B3] focus:ring-1 focus:ring-[#0056B3] bg-[#f8fbff]"
                        >
                        @error('tanggal_pelaksanaan')
                            <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="block font-bold text-[#131D4F]">Waktu Mulai Acara</label>
                        <input 
                            type="time" 
                            name="waktu_mulai" 
                            value="{{ old('waktu_mulai', substr($event->waktu_mulai, 0, 5)) }}" 
                            required 
                            class="w-full border-2 border-blue-100 rounded-2xl p-3 text-sm focus:border-[#0056B3] focus:ring-1 focus:ring-[#0056B3] bg-[#f8fbff]"
                        >
                        @error('waktu_mulai')
                            <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="block font-bold text-[#131D4F]">Waktu Selesai Acara</label>
                        <input 
                            type="time" 
                            name="waktu_selesai" 
                            value="{{ old('waktu_selesai', substr($event->waktu_selesai, 0, 5)) }}" 
                            required 
                            class="w-full border-2 border-blue-100 rounded-2xl p-3 text-sm focus:border-[#0056B3] focus:ring-1 focus:ring-[#0056B3] bg-[#f8fbff]"
                        >
                        @error('waktu_selesai')
                            <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2">
                    <div class="space-y-1.5">
                        <label class="block font-bold text-[#131D4F]">Ganti Poster Baru (Opsional)</label>
                        <input 
                            type="file" 
                            name="poster" 
                            accept="image/*" 
                            class="w-full text-xs border-2 border-blue-50 rounded-2xl p-2.5 bg-[#f8fbff] file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-[#0056B3] hover:file:bg-blue-100 transition-all"
                        >
                        @error('poster')
                            <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="block font-bold text-[#131D4F]">Ganti Dokumen Proposal Baru (Opsional)</label>
                        <input 
                            type="file" 
                            name="proposal" 
                            accept=".pdf" 
                            class="w-full text-xs border-2 border-blue-50 rounded-2xl p-2.5 bg-[#f8fbff] file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-[#0056B3] hover:file:bg-blue-100 transition-all"
                        >
                        @error('proposal')
                            <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-5 border-t border-blue-50 font-bold">
                    <a href="{{ route('event.index') }}" class="px-5 py-2.5 border-2 border-blue-100 text-gray-500 rounded-2xl hover:bg-gray-50 transition flex items-center justify-center">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-[#0056B3] hover:bg-[#131D4F] text-white rounded-2xl shadow-md transition flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection