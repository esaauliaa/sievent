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
            <div class="px-6 py-5 border-b border-blue-100 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-extrabold text-[#131D4F]">
                        Daftar Ruangan
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Menampilkan seluruh data ruangan yang ada di Universitas Jember.
                    </p>
                </div>
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

                    <tbody class="divide-y divide-blue-50">
                        @forelse ($ruangans as $index => $ruangan)
                            <tr class="hover:bg-blue-50/50 transition">
                                <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                                    {{ $index + 1 }}
                                </td>

                                <td class="px-6 py-4 font-bold text-[#131D4F] min-w-[260px]">
                                    {{ $ruangan->nama_ruangan }}
                                </td>

                                <td class="px-6 py-4 text-gray-600 min-w-[260px]">
                                    {{ $ruangan->lokasi }}
                                </td>

                                <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                                    {{ $ruangan->kapasitas }} orang
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($ruangan->status_ruangan === 'tersedia')
                                        <span class="inline-flex items-center whitespace-nowrap rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-700">
                                            Tersedia
                                        </span>
                                    @else
                                        <span class="inline-flex items-center whitespace-nowrap rounded-full bg-red-100 px-4 py-2 text-sm font-semibold text-red-700">
                                            Tidak Tersedia
                                        </span>
                                    @endif
                                </td>

                                @if (Auth::user()->role === 'admin')
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-3">
                                            <a
                                                href="{{ route('ruangan.edit', $ruangan->id_ruangan) }}"
                                                class="w-11 h-11 rounded-xl bg-yellow-400 text-[#131D4F] flex items-center justify-center hover:bg-yellow-500 transition shadow-sm"
                                                title="Edit Ruangan"
                                            >
                                                <i class="fa-solid fa-pen"></i>
                                            </a>

                                            <form
                                                method="POST"
                                                action="{{ route('ruangan.destroy', $ruangan->id_ruangan) }}"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus ruangan ini?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="w-11 h-11 rounded-xl bg-red-600 text-white flex items-center justify-center hover:bg-red-700 transition shadow-sm"
                                                    title="Hapus Ruangan"
                                                >
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="{{ Auth::user()->role === 'admin' ? 6 : 5 }}"
                                    class="px-6 py-10 text-center text-gray-500"
                                >
                                    Belum ada data ruangan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
