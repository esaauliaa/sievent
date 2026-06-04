@extends('layouts.' . Auth::user()->role)

@section('title', 'Tambah Event - SiEvent UNEJ')

@section('page-title', 'Tambah Event')

@section('content')
<div class="max-w-7xl mx-auto">

    <div class="mb-8">
        <div class="bg-gradient-to-r from-[#0056B3] to-[#131D4F] rounded-3xl p-8 text-white shadow-lg relative overflow-hidden">
            <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full translate-x-20 -translate-y-20"></div>
            <div class="absolute right-24 bottom-0 w-32 h-32 bg-white/10 rounded-full translate-y-16"></div>

            <div class="relative z-10">
                <h2 class="text-3xl font-extrabold mb-3">
                    Tambah Event
                </h2>
                <p class="text-white/85 max-w-2xl leading-relaxed">
                    Tambahkan data event yang dapat digunakan untuk kegiatan kampus.
                </p>
            </div>
        </div>
    </div>

    @if(session('error'))
        <div class="mb-5 p-4 rounded-2xl bg-red-100 border border-red-200 text-red-700 font-semibold">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-5 p-4 rounded-2xl bg-red-100 border border-red-200">
            <ul class="text-sm text-red-700 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-3xl border border-blue-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-blue-100">
            <h3 class="text-lg font-extrabold text-[#131D4F]">
                Form Tambah Event
            </h3>
            <p class="text-sm text-gray-500 mt-1">
                Isi data event dengan benar.
            </p>
        </div>

        <form action="{{ route('event.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="p-6 space-y-6">

            @csrf

            <div class="space-y-2">
                <label class="text-sm font-bold text-[#131D4F]">
                    Nama Event
                </label>
                <div class="relative">
                    <i class="fa-solid fa-file-signature absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input
                        type="text"
                        name="nama_event"
                        value="{{ old('nama_event') }}"
                        placeholder="Contoh: Seminar Teknologi"
                        class="w-full h-12 pl-11 pr-4 rounded-2xl border-2 border-blue-100 bg-[#f8fbff]"
                    >
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-bold text-[#131D4F]">
                    Deskripsi Event
                </label>
                <textarea
                    name="deskripsi"
                    rows="4"
                    placeholder="Masukkan deskripsi event"
                    class="w-full p-4 rounded-2xl border-2 border-blue-100 bg-[#f8fbff]"
                >{{ old('deskripsi') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="space-y-2">
                    <label class="text-sm font-bold text-[#131D4F]">
                        Tanggal Pelaksanaan
                    </label>
                    <input
                        type="date"
                        name="tanggal_pelaksanaan"
                        id="tanggal_pelaksanaan"
                        value="{{ old('tanggal_pelaksanaan') }}"
                        class="w-full h-12 px-4 rounded-2xl border-2 border-blue-100 bg-[#f8fbff]"
                    >
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-[#131D4F]">
                        Waktu Mulai
                    </label>
                    <input
                        type="time"
                        name="waktu_mulai"
                        value="{{ old('waktu_mulai') }}"
                        class="w-full h-12 px-4 rounded-2xl border-2 border-blue-100 bg-[#f8fbff]"
                    >
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-[#131D4F]">
                        Waktu Selesai
                    </label>
                    <input
                        type="time"
                        name="waktu_selesai"
                        value="{{ old('waktu_selesai') }}"
                        class="w-full h-12 px-4 rounded-2xl border-2 border-blue-100 bg-[#f8fbff]"
                    >
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-bold text-[#131D4F]">
                    Pilih Ruangan
                </label>
                <div class="relative">
                    <i class="fa-solid fa-building absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <select
                        name="id_ruangan"
                        id="id_ruangan"
                        class="w-full h-12 pl-11 pr-4 rounded-2xl border-2 border-blue-100 bg-[#f8fbff]"
                        disabled
                    >
                        <option value="">
                            Harap isi tanggal pelaksanaan terlebih dahulu
                        </option>
                    </select>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-bold text-[#131D4F]">
                    Jumlah Peserta
                </label>
                <div class="relative">
                    <i class="fa-solid fa-users absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input
                        type="number"
                        name="kuota"
                        min="1"
                        value="{{ old('kuota') }}"
                        placeholder="Contoh: 100"
                        class="w-full h-12 pl-11 pr-4 rounded-2xl border-2 border-blue-100 bg-[#f8fbff]"
                    >
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="text-sm font-bold text-[#131D4F]">
                        Upload Poster <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="file"
                        name="poster"
                        accept="image/*"
                        class="w-full h-12 px-4 rounded-2xl border-2 border-blue-100 bg-[#f8fbff]"
                    >
                    <p class="text-xs text-gray-400">
                        JPG, PNG, WEBP (Max 5MB) - <span class="text-red-500 font-semibold">Wajib diunggah</span>
                    </p>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-[#131D4F]">
                        Upload Proposal PDF <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="file"
                        name="proposal"
                        accept=".pdf"
                        class="w-full h-12 px-4 rounded-2xl border-2 border-blue-100 bg-[#f8fbff]"
                    >
                    <p class="text-xs text-gray-400">
                        PDF (Max 20MB) - <span class="text-red-500 font-semibold">Wajib diunggah</span>
                    </p>
                </div>
            </div>

            <div class="pt-4 border-t border-blue-50 flex justify-between gap-4">
                <a
                    href="{{ route('event.index') }}"
                    class="px-6 h-12 inline-flex items-center justify-center rounded-2xl bg-gray-100 text-gray-700 hover:bg-gray-200 transition font-bold text-sm"
                >
                    Kembali
                </a>
                <button
                    type="submit"
                    class="px-6 h-12 inline-flex items-center justify-center rounded-2xl bg-[#0056B3] text-white hover:bg-[#004494] transition font-bold text-sm gap-2"
                >
                    <i class="fa-solid fa-paper-plane"></i>
                    Ajukan Event
                </button>
            </div>
        </form>
    </div>

    <div class="mt-8 bg-white rounded-3xl border border-blue-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-blue-100">
            <h3 class="text-lg font-extrabold text-[#131D4F]">
                Riwayat Pengajuan Event Anda
            </h3>
            <p class="text-sm text-gray-500 mt-1">
                Menampilkan daftar seluruh kegiatan yang telah Anda ajukan ke dalam sistem SiEvent.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-[#e1effe] text-[#131D4F]">
                    <tr>
                        <th class="px-6 py-4 text-sm font-extrabold text-center w-16">No</th>
                        <th class="px-6 py-4 text-sm font-extrabold">Nama Event</th>
                        <th class="px-6 py-4 text-sm font-extrabold">Nama Ruangan</th>
                        <th class="px-6 py-4 text-sm font-extrabold">Tanggal & Waktu</th>
                        <th class="px-6 py-4 text-sm font-extrabold">Kuota</th>
                        <th class="px-6 py-4 text-sm font-extrabold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-blue-50 text-sm text-gray-700">
                    @forelse($events as $index => $item)
                        <tr class="hover:bg-slate-50/50 transition-all">
                            <td class="px-6 py-4 text-center text-gray-400 font-medium">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-[#131D4F] block">{{ $item->nama_event }}</span>
                                <span class="text-xs text-gray-400 line-clamp-1 mt-0.5">{{ $item->deskripsi }}</span>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-600">
                                {{ $item->ruangan->nama_ruangan ?? 'Ruangan Tidak Ditemukan' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="block font-medium text-gray-800">{{ \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->translatedFormat('d F Y') }}</span>
                                <span class="text-xs text-gray-400 mt-0.5 block">{{ substr($item->waktu_mulai, 0, 5) }} - {{ substr($item->waktu_selesai, 0, 5) }} WIB</span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-600">{{ $item->kuota }} orang</td>
                            <td class="px-6 py-4">
                                @if($item->status === 'disetujui' || $item->status === 'approved')
                                    <span class="inline-block px-3 py-1 text-xs font-bold bg-green-100 text-green-700 rounded-full">Disetujui</span>
                                @elseif($item->status === 'pending')
                                    <span class="inline-block px-3 py-1 text-xs font-bold bg-amber-100 text-amber-700 rounded-full">Pending</span>
                                @else
                                    <span class="inline-block px-3 py-1 text-xs font-bold bg-red-100 text-red-600 rounded-full">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-400 italic font-medium">
                                Anda belum pernah mengajukan event apa pun.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
function muatRuanganTersedia() {
    let tanggal = document.getElementById('tanggal_pelaksanaan').value;
    let ruangan = document.getElementById('id_ruangan');

    if (!tanggal) {
        ruangan.disabled = true;
        ruangan.innerHTML = '<option value="">Harap isi tanggal pelaksanaan terlebih dahulu</option>';
        return;
    }

    ruangan.disabled = false;
    ruangan.innerHTML = '<option value="">Sedang memuat ruangan...</option>';

    fetch('{{ route("event.getRuanganByTanggal") }}?tanggal=' + tanggal)
        .then(response => response.json())
        .then(data => {
            ruangan.innerHTML = '';

            if (data.length == 0) {
                ruangan.innerHTML = '<option value="">Tidak ada ruangan tersedia</option>';
            } else {
                ruangan.innerHTML = '<option value="">Pilih Ruangan</option>';
                data.forEach(item => {
                    ruangan.innerHTML += `
                        <option value="${item.id_ruangan}">
                            ${item.nama_ruangan} (Kapasitas ${item.kapasitas})
                        </option>
                    `;
                });
            }
        })
        .catch(error => {
            ruangan.innerHTML = '<option value="">Gagal memuat data ruangan</option>';
        });
}

document.getElementById('tanggal_pelaksanaan').addEventListener('change', muatRuanganTersedia);

if (document.getElementById('tanggal_pelaksanaan').value) {
    muatRuanganTersedia();
}
</script>
@endsection