@extends('layouts.' . Auth::user()->role)

@section('title', 'Status Konfirmasi Presensi')

@section('content')
<div class="max-w-md mx-auto my-12 px-4">
    <div class="bg-white rounded-3xl border border-blue-100 shadow-xl overflow-hidden p-6 text-center space-y-5">
        
        @if($status === 'success')
            <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-3xl mx-auto shadow-inner">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-green-800">Presensi Sukses!</h2>
        @else
            <div class="w-16 h-16 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center text-3xl mx-auto shadow-inner">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-amber-800">Sudah Terisi</h2>
        @endif

        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 text-sm space-y-1 text-left">
            <p class="text-gray-500 font-medium">Nama: <span class="text-gray-800 font-bold">{{ $peserta->user->nama ?? '-' }}</span></p>
            <p class="text-gray-500 font-medium">Acara: <span class="text-gray-800 font-bold">{{ $peserta->event->nama_event }}</span></p>
            <p class="text-gray-500 font-medium">Waktu Presensi: <span class="text-[#0056B3] font-mono font-bold">{{ date('H:i:s WIB') }}</span></p>
        </div>

        <p class="text-xs text-gray-500 font-medium leading-relaxed px-2">
            {{ $pesan }}
        </p>

        <div class="pt-4">
            <a href="{{ route('event.index') }}" class="px-6 py-2.5 bg-[#131D4F] text-white text-xs font-bold rounded-xl hover:bg-[#0056B3] transition inline-block shadow-sm">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
