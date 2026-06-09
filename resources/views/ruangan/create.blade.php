@extends('layouts.admin')

@section('title', 'Tambah Ruangan - SiEvent UNEJ')

@section('page-title', 'Tambah Ruangan')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <div class="bg-gradient-to-r from-[#0056B3] to-[#131D4F] rounded-3xl p-8 text-white shadow-lg">
                <h2 class="text-3xl font-extrabold mb-3">
                    Tambah Ruangan
                </h2>

                <p class="text-white/85 leading-relaxed">
                    Tambahkan data ruangan yang dapat digunakan untuk kegiatan atau event kampus.
                </p>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-blue-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-blue-100">
                <h3 class="text-lg font-extrabold text-[#131D4F]">
                    Form Tambah Ruangan
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    Isi data ruangan dengan benar.
                </p>
            </div>

            <form method="POST" action="{{ route('ruangan.store') }}" class="p-6 space-y-6">
                @csrf

                <div>
                    <label for="nama_ruangan" class="block mb-2 text-sm font-bold text-[#1b3028]">
                        Nama Ruangan
                    </label>

                    <div class="relative">
                        <i class="fa-solid fa-door-open absolute left-4 top-1/2 -translate-y-1/2 text-[#4d5f5d]"></i>

                        <input
                            id="nama_ruangan"
                            type="text"
                            name="nama_ruangan"
                            value="{{ old('nama_ruangan') }}"
                            placeholder="Contoh: Aula Fakultas Ilmu Komputer"
                            class="w-full h-[52px] pl-11 pr-4 text-sm rounded-xl border-2 border-[#0056B3] bg-[#e1effe] text-[#1b3028] placeholder:text-gray-500 focus:ring-1 focus:ring-[#0056B3] focus:border-[#0056B3]"
                        >
                    </div>

                    <x-input-error :messages="$errors->get('nama_ruangan')" class="mt-2" />
                </div>

                <div>
                    <label for="lokasi" class="block mb-2 text-sm font-bold text-[#1b3028]">
                        Lokasi
                    </label>

                    <div class="relative">
                        <i class="fa-solid fa-location-dot absolute left-4 top-1/2 -translate-y-1/2 text-[#4d5f5d]"></i>

                        <input
                            id="lokasi"
                            type="text"
                            name="lokasi"
                            value="{{ old('lokasi') }}"
                            placeholder="Contoh: Gedung FASILKOM UNEJ Lantai 2"
                            class="w-full h-[52px] pl-11 pr-4 text-sm rounded-xl border-2 border-[#0056B3] bg-[#e1effe] text-[#1b3028] placeholder:text-gray-500 focus:ring-1 focus:ring-[#0056B3] focus:border-[#0056B3]"
                        >
                    </div>

                    <x-input-error :messages="$errors->get('lokasi')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="kapasitas" class="block mb-2 text-sm font-bold text-[#1b3028]">
                            Kapasitas
                        </label>

                        <div class="relative">
                            <i class="fa-solid fa-users absolute left-4 top-1/2 -translate-y-1/2 text-[#4d5f5d]"></i>

                            <input
                                id="kapasitas"
                                type="number"
                                name="kapasitas"
                                min="1"
                                value="{{ old('kapasitas') }}"
                                placeholder="Contoh: 100"
                                class="w-full h-[52px] pl-11 pr-4 text-sm rounded-xl border-2 border-[#0056B3] bg-[#e1effe] text-[#1b3028] placeholder:text-gray-500 focus:ring-1 focus:ring-[#0056B3] focus:border-[#0056B3]"
                            >
                        </div>

                        <x-input-error :messages="$errors->get('kapasitas')" class="mt-2" />
                    </div>

                    <div>
                        <label for="status_ruangan" class="block mb-2 text-sm font-bold text-[#1b3028]">
                            Status Ruangan
                        </label>

                        <div class="relative">
                            <i class="fa-solid fa-circle-check absolute left-4 top-1/2 -translate-y-1/2 text-[#4d5f5d]"></i>

                            <select
                                id="status_ruangan"
                                name="status_ruangan"
                                class="w-full h-[52px] pl-11 pr-4 text-sm rounded-xl border-2 border-[#0056B3] bg-[#e1effe] text-[#1b3028] focus:ring-1 focus:ring-[#0056B3] focus:border-[#0056B3]"
                            >
                                <option value="">Pilih status ruangan</option>
                                <option value="tersedia" {{ old('status_ruangan') === 'tersedia' ? 'selected' : '' }}>
                                    Tersedia
                                </option>
                                <option value="tidak_tersedia" {{ old('status_ruangan') === 'tidak_tersedia' ? 'selected' : '' }}>
                                    Tidak Tersedia
                                </option>
                            </select>
                        </div>

                        <x-input-error :messages="$errors->get('status_ruangan')" class="mt-2" />
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-between">
                    <a
                        href="{{ route('ruangan.index') }}"
                        class="px-6 py-3 rounded-2xl bg-gray-100 text-gray-700 font-bold hover:bg-gray-200 transition"
                    >
                        Kembali
                    </a>

                    <button
                        type="submit"
                        class="px-8 py-3 rounded-2xl bg-[#0056B3] text-white font-extrabold hover:bg-[#131D4F] transition shadow-md"
                    >
                        <i class="fa-solid fa-floppy-disk mr-2"></i>
                        Simpan Ruangan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
