@extends('layouts.' . Auth::user()->role)

@section('title', 'Tiket QR Code Anda')

@section('content')
<div class="max-w-md mx-auto my-10 px-4">
    <div class="bg-white rounded-3xl border border-blue-100 shadow-xl overflow-hidden text-center p-6 space-y-6">
        
        <div>
            <h2 class="text-xl font-extrabold text-[#131D4F]">Tiket Presensi Digital</h2>
            <p class="text-xs text-gray-400 mt-1">Silakan tunjukkan QR Code ini ke Panitia/Admin untuk di-scan.</p>
        </div>

        <div class="bg-[#f8fbff] p-6 rounded-2xl border-2 border-dashed border-blue-100 inline-block">
            <img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl={{ urlencode($urlPresensi) }}&choe=UTF-8" 
                 alt="QR Code Tiket Presensi" 
                 class="mx-auto w-[200px] h-[200px] shadow-sm rounded-lg">
        </div>

        <div class="border-t border-gray-100 pt-4 space-y-2">
            <h3 class="font-extrabold text-[#131D4F] text-base">{{ $peserta->event->nama_event }}</h3>
            <p class="text-xs text-gray-500 font-semibold">Peserta: <span class="text-[#0056B3] font-bold">{{ $peserta->user->name }}</span></p>
            <p class="text-xs text-gray-400">Status Kehadiran:</p>
            
            @if($peserta->status_kehadiran === 'hadir')
                <span class="inline-block px-3 py-1 text-xs font-bold bg-green-100 text-green-700 rounded-full">✓ Sudah Hadir</span>
            @else
                <span class="inline-block px-3 py-1 text-xs font-bold bg-amber-100 text-amber-700 rounded-full animate-pulse">● Belum Hadir</span>
            @endif
        </div>

        <div class="pt-2">
            <a href="{{ route('event.index') }}" class="text-xs font-bold text-gray-400 hover:text-gray-600 hover:underline">
                ← Kembali ke Daftar Event
            </a>
        </div>
    </div>
</div>
@endsection