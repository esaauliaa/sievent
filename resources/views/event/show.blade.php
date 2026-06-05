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
            <div class="mb-6 p-4 rounded-2xl bg-green-100 text-green-700 font-bold">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-red-100 text-red-700 font-bold">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1">
                <div class="bg-white p-5 rounded-3xl border border-blue-100 shadow-sm sticky top-6">
                    <p class="text-sm font-extrabold text-[#131D4F] mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-image text-gray-400"></i> Poster Kegiatan
                    </p>
                    <div class="w-full aspect-[3/4] bg-[#f8fbff] rounded-2xl overflow-hidden shadow-inner flex flex-col items-center justify-center border-2 border-dashed border-blue-100">
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

                    @if(Auth::user()->role !== 'mahasiswa')
                        <div>
                            @if(\Carbon\Carbon::parse($event->tanggal_pelaksanaan)->isPast() && !\Carbon\Carbon::parse($event->tanggal_pelaksanaan)->isToday())
                                <span class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-extrabold bg-gray-100 text-gray-500 rounded-full border border-gray-200">
                                    <span class="w-2 h-2 rounded-full bg-gray-400"></span> Selesai (Arsip)
                                </span>
                            @elseif($event->status === 'disetujui' || $event->status === 'approved')
                                <span class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-extrabold bg-green-100 text-green-700 rounded-full border border-green-200">
                                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Disetujui (Aktif)
                                </span>
                            @elseif($event->status === 'pending')
                                <span class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-extrabold bg-amber-100 text-amber-600 rounded-full border border-amber-200">
                                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span> Menunggu Konfirmasi
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-extrabold bg-red-100 text-red-700 rounded-full border border-red-200">
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span> Ditolak
                                </span>
                            @endif
                        </div>
                    @endif
                </div>

                @if($event->status === 'ditolak' && !empty($event->alasan_penolakan))
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
                                <p class="font-extrabold text-[#131D4F] text-base mt-0.5">
                                    {{ \Carbon\Carbon::parse($event->tanggal_pelaksanaan)->translatedFormat('d F Y') }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-blue-50 rounded-2xl text-[#0056B3] flex-shrink-0">
                                <i class="fa-solid fa-hourglass-start fa-fw text-lg"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Waktu / Jam Operasional</p>
                                <p class="font-extrabold text-[#131D4F] text-base mt-0.5">
                                    {{ substr($event->waktu_mulai, 0, 5) }} - {{ substr($event->waktu_selesai, 0, 5) }} WIB
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-blue-50 rounded-2xl text-[#0056B3] flex-shrink-0">
                                <i class="fa-solid fa-map-location-dot fa-fw text-lg"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Alokasi Tempat</p>
                                <p class="font-extrabold text-[#131D4F] text-base mt-0.5">
                                    {{ $event->ruangan->nama_ruangan ?? 'Ruangan Tidak Ditemukan' }}
                                </p>
                            </div>
                        </div>

                        @if(Auth::user()->role !== 'mahasiswa')
                            <div class="flex items-start gap-4">
                                <div class="p-3 bg-blue-50 rounded-2xl text-[#0056B3] flex-shrink-0">
                                    <i class="fa-solid fa-users-rectangle fa-fw text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Keterisian / Kuota Maksimal</p>
                                    <p class="font-extrabold text-[#131D4F] text-base mt-0.5">
                                        {{ $event->peserta->count() }} / {{ $event->kuota }} Orang Mendaftar
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                @if(Auth::user()->role !== 'mahasiswa')
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
                                    <p class="text-xs text-gray-400 mt-0.5 whitespace-normal lg:whitespace-nowrap">
                                        Format berkas resmi proposal perizinan kegiatan SiEvent.
                                    </p>
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
                @endif

                <div class="bg-white p-6 rounded-3xl border border-blue-100 shadow-sm">
                    <h3 class="text-lg font-extrabold text-[#131D4F] mb-4 border-b border-blue-50 pb-2 flex items-center gap-2">
                        <i class="fa-solid fa-align-left text-gray-400 text-base"></i> Deskripsi Tambahan Acara
                    </h3>

                    <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-line bg-[#f8fbff] p-4 rounded-2xl border border-blue-50">
                        {{ $event->deskripsi ?? 'Tidak ada rincian deskripsi tambahan yang dimasukkan oleh penyelenggara.' }}
                    </p>
                </div>

                @if(Auth::user()->role === 'admin' && $event->status === 'pending')
                    <div class="bg-white p-6 rounded-3xl border border-blue-100 shadow-sm space-y-4 pt-6">
                        <div class="border-b border-gray-100 pb-2">
                            <h4 class="text-sm font-extrabold text-[#131D4F] flex items-center gap-2">
                                <i class="fa-solid fa-gavel text-gray-400"></i> Panel Keputusan Verifikasi Admin
                            </h4>
                        </div>

                        <div class="flex flex-col lg:flex-row items-stretch justify-end gap-4 pt-2">
                            <form id="rejectForm" action="{{ route('event.tolak', $event->id_event ?? $event->id) }}" method="POST" class="flex-1 space-y-3">
                                @csrf
                                <div class="space-y-1.5">
                                    <label for="alasan_penolakan" class="text-xs font-bold text-gray-500">Alasan Penolakan (Wajib diisi jika menolak kegiatan):</label>
                                    <textarea 
                                        name="alasan_penolakan" 
                                        id="alasan_penolakan" 
                                        rows="2" 
                                        placeholder="Contoh: Berkas proposal belum ditandatangani oleh Dosen Pembimbing / Jadwal bentrok..."
                                        class="w-full p-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-[#131D4F] focus:bg-white focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all"
                                    ></textarea>
                                </div>

                                <div class="flex justify-end">
                                    <button type="button" onclick="submitPenolakan()" class="px-5 h-11 inline-flex items-center justify-center rounded-xl bg-red-600 text-white hover:bg-red-700 transition font-bold text-xs gap-1.5 shadow-sm w-full lg:w-auto">
                                        <i class="fa-solid fa-circle-xmark text-sm"></i> Tolak Pengajuan
                                    </button>
                                </div>
                            </form>

                            <div class="flex items-end justify-end">
                                <form action="{{ route('event.konfirmasi', $event->id_event ?? $event->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memberikan perizinan dan menyetujui kegiatan ini?')" class="w-full lg:w-auto">
                                    @csrf
                                    <button type="submit" class="px-5 h-11 inline-flex items-center justify-center rounded-xl bg-[#0056B3] text-white hover:bg-[#131D4F] transition font-bold text-xs gap-1.5 shadow-sm w-full">
                                        <i class="fa-solid fa-circle-check text-sm"></i> Konfirmasi Perizinan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <script>
                        function submitPenolakan() {
                            const alasan = document.getElementById('alasan_penolakan').value.trim();
                            if (alasan === '') {
                                alert('Gagal memproses! Anda wajib mengisi alasan penolakan terlebih dahulu.');
                                return false;
                            }
                            if (confirm('Apakah Anda yakin ingin menolak pengajuan kegiatan ini dengan alasan tersebut?')) {
                                document.getElementById('rejectForm').submit();
                            }
                        }
                    </script>
                @endif

            </div>
        </div>
    </div>
@endsection