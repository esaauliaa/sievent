@extends('layouts.' . Auth::user()->role)

@section('title', 'Detail Event - SiEvent UNEJ')

@section('page-title', 'Detail Event')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <div class="bg-gradient-to-r from-[#0056B3] to-[#131D4F] rounded-3xl p-8 text-white shadow-lg relative overflow-hidden">
                <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full translate-x-20 -translate-y-20"></div>
                <div class="absolute right-24 bottom-0 w-32 h-32 bg-white/10 rounded-full translate-y-16"></div>

                <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-white/20 text-white mb-3 backdrop-blur-sm">
                            <i class="fa-solid fa-circle-info mr-1"></i> Informasi Lengkap
                        </span>
                        <h2 class="text-3xl font-extrabold mb-2 line-clamp-1">
                            {{ $event->nama_event }}
                        </h2>
                        <p class="text-white/85 max-w-2xl leading-relaxed text-sm">
                            Manajemen pengelolaan data detail event, status perizinan tempat, kuota, serta deskripsi lengkap acara.
                        </p>
                    </div>

                    <a href="{{ url()->previous() ?? route('event.index') }}" 
                       class="px-5 py-3 rounded-2xl bg-white/10 text-white hover:bg-white/20 transition font-bold shadow-md border border-white/20 text-center whitespace-nowrap text-sm backdrop-blur-sm">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-green-100 text-green-700 font-bold shadow-sm border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1">
                <div class="bg-white p-5 rounded-3xl border border-blue-100 shadow-sm sticky top-6">
                    <p class="text-sm font-extrabold text-[#131D4F] mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-image text-gray-400"></i> Poster Kegiatan
                    </p>
                    <div class="w-full aspect-[3/4] bg-[#f8fbff] rounded-2xl overflow-hidden shadow-inner flex flex-col items-center justify-center border-2 border-dashed border-blue-100">
                        {{-- Mengambil file gambar asli dari folder storage public --}}
                        @if(!empty($event->poster))
                            <img src="{{ asset('storage/' . $event->poster) }}" alt="Poster {{ $event->nama_event }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-center p-6">
                                <i class="fa-solid fa-images text-blue-200 text-5xl mb-3"></i>
                                <p class="text-xs text-gray-400 italic font-medium">Belum ada poster yang diunggah</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white p-6 rounded-3xl border border-blue-100 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Identifikasi Acara</p>
                        <p class="text-sm text-gray-500 mt-1">Kode Registrasi: <span class="font-mono font-bold text-gray-700 bg-gray-100 px-2 py-0.5 rounded">EVT-{{ $event->id_event ?? $event->id }}</span></p>
                    </div>
                    <div>
                        @if($event->status === 'disetujui' || $event->status === 'approved')
                            <span class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-extrabold bg-green-100 text-green-700 rounded-full border border-green-200">
                                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Disetujui (Aktif)
                            </span>
                        @elseif($event->status === 'pending')
                            <span class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-extrabold bg-amber-100 text-amber-600 rounded-full border border-amber-200">
                                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span> Menunggu Konfirmasi
                            </span>
                        @else($event->status === 'ditolak' && !empty($event->alasan_penolakan))
                            <div class="bg-red-50 p-5 rounded-3xl border border-red-200 shadow-sm flex items-start gap-3">
                                <div class="p-2 bg-red-100 text-red-700 rounded-xl flex-shrink-0">
                                    <i class="fa-solid fa-comment-slash text-base"></i>
                                </div>
                                <div>
                                    <p class="font-extrabold text-red-800 text-sm">Catatan Penolakan dari Admin:</p>
                                    <p class="text-xs text-red-700 mt-1 leading-relaxed bg-white/60 p-3 rounded-xl border border-red-100/60 font-medium">
                                        "{{ $event->alasan_penolakan }}"
                                    </p>
                                </div>
                            </div>
                        @endif
                            
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl border border-blue-100 shadow-sm">
                    <h3 class="text-lg font-extrabold text-[#131D4F] mb-5 border-b border-blue-50 pb-2 flex items-center gap-2">
                        <i class="fa-solid fa-clock text-gray-400 text-base"></i> Logistik & Waktu Pelaksanaan
                    </h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-blue-50 rounded-2xl text-[#0056B3] flex-shrink-0">
                                <i class="fa-solid fa-calendar-day fa-fw text-lg"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Tanggal Pelaksanaan</p>
                                <p class="font-extrabold text-[#131D4F] text-base mt-0.5">{{ \Carbon\Carbon::parse($event->tanggal_pelaksanaan)->translatedFormat('d F Y') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-blue-50 rounded-2xl text-[#0056B3] flex-shrink-0">
                                <i class="fa-solid fa-hourglass-start fa-fw text-lg"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Waktu / Jam Operasional</p>
                                <p class="font-extrabold text-[#131D4F] text-base mt-0.5">{{ substr($event->waktu_mulai, 0, 5) }} - {{ substr($event->waktu_selesai, 0, 5) }} WIB</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-blue-50 rounded-2xl text-[#0056B3] flex-shrink-0">
                                <i class="fa-solid fa-map-location-dot fa-fw text-lg"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Alokasi Tempat</p>
                                <p class="font-extrabold text-[#131D4F] text-base mt-0.5">ID Ruangan: {{ $event->id_ruangan }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-blue-50 rounded-2xl text-[#0056B3] flex-shrink-0">
                                <i class="fa-solid fa-users-rectangle fa-fw text-lg"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Kapasitas / Kuota</p>
                                <p class="font-extrabold text-[#131D4F] text-base mt-0.5">{{ $event->kuota }} Orang Terdaftar</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl border border-blue-100 shadow-sm">
                    <h3 class="text-lg font-extrabold text-[#131D4F] mb-4 border-b border-blue-50 pb-2 flex items-center gap-2">
                        <i class="fa-solid fa-file-pdf text-gray-400 text-base"></i> Dokumen Pendukung / Proposal
                    </h3>
                    
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-xl flex-shrink-0">
                                <i class="fa-solid fa-file-lines"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="font-bold text-gray-800 text-sm truncate">Berkas Dokumen Pengajuan</p>
                                <p class="text-xs text-gray-400 mt-0.5 whitespace-normal lg:whitespace-nowrap">Format berkas resmi proposal perizinan kegiatan SiEvent.</p>
                            </div>
                        </div>
                        
                        <div class="w-full lg:w-auto flex-shrink-0">
                            @if(!empty($event->proposal))
                                <a href="{{ asset('storage/' . $event->proposal) }}" target="_blank" 
                                   class="w-full lg:w-auto inline-flex items-center justify-center gap-2 px-5 h-11 bg-[#0056B3] text-white text-xs font-extrabold rounded-xl hover:bg-[#131D4F] transition shadow-sm whitespace-nowrap">
                                    <i class="fa-solid fa-download"></i> Lihat & Unduh Proposal
                                </a>
                            @else
                                <span class="w-full lg:w-auto inline-flex items-center justify-center gap-2 text-xs text-gray-400 italic font-medium px-4 h-11 bg-gray-100 rounded-xl border border-dashed border-gray-200 whitespace-nowrap">
                                    <i class="fa-solid fa-ban"></i> Proposal Tidak Ada
                                </span>
                            @endif
                        </div>

                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-3xl border border-blue-100 shadow-sm">
                    <h3 class="text-lg font-extrabold text-[#131D4F] mb-4 border-b border-blue-50 pb-2 flex items-center gap-2">
                        <i class="fa-solid fa-align-left text-gray-400 text-base"></i> Deskripsi Tambahan Acara
                    </h3>
                    <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-line bg-[#f8fbff] p-4 rounded-2xl border border-blue-50">
                        {{ $event->deskripsi ?? 'Tidak ada rincian deskripsi tambahan yang dimasukkan oleh penyelenggara.' }}
                    </p>
                </div>

                @if(Auth::user()->role === 'admin' && $event->status === 'pending')
                    <div class="bg-amber-50 p-6 rounded-3xl border-2 border-dashed border-amber-200 shadow-inner">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5 mb-5">
                            <div class="flex items-start gap-3">
                                <div class="p-2.5 bg-amber-100 rounded-xl text-amber-800 flex-shrink-0 mt-0.5">
                                    <i class="fa-solid fa-triangle-exclamation text-base"></i>
                                </div>
                                <div>
                                    <p class="font-extrabold text-amber-800 text-base">Menunggu Keputusan Admin</p>
                                    <p class="text-xs text-amber-600/90 mt-0.5 font-medium leading-relaxed max-w-xl">
                                        Validasi seluruh berkas proposal dan kesesuaian ruang/waktu sebelum mengambil keputusan menyetujui atau menolak pengajuan ini.
                                    </p>
                                </div>
                            </div>
                            
                            <div class="w-full md:w-auto flex flex-col sm:flex-row items-center gap-3 flex-shrink-0">
                                <button type="button" onclick="toggleRejectForm()" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 h-12 bg-red-600 text-white text-sm font-extrabold rounded-2xl hover:bg-red-700 transition shadow-md whitespace-nowrap">
                                    <i class="fa-solid fa-circle-xmark"></i> Tolak Pengajuan...
                                </button>

                                <form action="{{ route('event.konfirmasi', $event->id_event ?? $event->id) }}" method="POST" class="w-full sm:w-auto">
                                    @csrf
                                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 h-12 bg-[#0056B3] text-white text-sm font-extrabold rounded-2xl hover:bg-[#131D4F] transition shadow-md whitespace-nowrap">
                                        <i class="fa-solid fa-check-to-slot"></i> Setujui & Izinkan
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div id="rejectFormSection" class="hidden pt-4 border-t border-amber-200/60 transition-all duration-300">
                            <form action="{{ route('event.tolak', $event->id_event ?? $event->id) }}" method="POST" class="space-y-3">
                                @csrf
                                <label for="alasan_penolakan" class="text-xs font-bold text-red-800 block uppercase tracking-wider">
                                    Alasan Penolakan Kegiatan <span class="text-red-500">*</span>
                                </label>
                                <textarea 
                                    id="alasan_penolakan" 
                                    name="alasan_penolakan" 
                                    rows="3" 
                                    placeholder="Contoh: Maaf, pada tanggal tersebut Aula Fasilkom sudah dibooking untuk acara Yudisium. Silakan ganti tanggal pelaksanaan..."
                                    class="w-full p-4 rounded-2xl border-2 border-red-200 bg-white text-sm text-gray-800 focus:border-red-600 focus:ring-1 focus:ring-red-600 placeholder-gray-400"
                                    required
                                ></textarea>
                                
                                <div class="flex justify-end gap-2">
                                    <button type="button" onclick="toggleRejectForm()" class="px-4 h-10 rounded-xl bg-gray-200 text-gray-700 text-xs font-bold hover:bg-gray-300 transition">
                                        Batal
                                    </button>
                                    <button type="submit" class="px-5 h-10 rounded-xl bg-red-600 text-white text-xs font-bold hover:bg-red-700 transition shadow-sm">
                                        Kirim & Tolak Permanen
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <script>
                        function toggleRejectForm() {
                            const section = document.getElementById('rejectFormSection');
                            section.classList.toggle('hidden');
                            if(!section.classList.contains('hidden')){
                                document.getElementById('alasan_penolakan').focus();
                            }
                        }
                    </script>
                @endif
            </div>
        </div>
    </div>
@endsection