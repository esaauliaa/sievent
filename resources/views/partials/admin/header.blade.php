@php
    $user = Auth::user();

    $roleLabel = match ($user->role) {
        'admin' => 'Administrator',
        'penyelenggara' => 'Penyelenggara',
        'mahasiswa' => 'Mahasiswa',
        default => ucfirst($user->role),
    };
@endphp

<header class="h-[78px] bg-white/95 backdrop-blur border-b border-blue-100 shadow-sm flex items-center justify-between px-6 lg:px-8 sticky top-0 z-20">
    <div class="flex items-center gap-4">
        <!-- Tombol Sidebar -->
        <button
            type="button"
            onclick="openSidebar()"
            class="w-11 h-11 rounded-2xl bg-[#e1effe] border border-blue-100 text-[#0056B3] flex items-center justify-center hover:bg-blue-100 transition"
        >
            <i class="fa-solid fa-bars text-lg"></i>
        </button>

        <div>
            <h1 class="text-xl lg:text-2xl font-extrabold text-[#131D4F]">
                @yield('page-title', 'Dashboard Admin')
            </h1>

            <p class="hidden sm:block text-sm text-gray-500 mt-1">
                Sistem Manajemen Pengelolaan Event Kampus Universitas Jember
            </p>
        </div>
    </div>

    <div class="flex items-center gap-4">
        <div class="hidden md:block text-right">
            <p class="text-sm font-bold text-[#131D4F]">
                {{ $user->nama ?? 'Admin SiEvent' }}
            </p>

            <p class="text-xs text-gray-500">
                {{ $roleLabel }}
            </p>
        </div>

        <!-- Foto Profil User -->
        <div class="w-11 h-11 rounded-full bg-[#e1effe] border-2 border-[#0056B3] overflow-hidden flex items-center justify-center text-[#0056B3]">
            @if ($user->foto)
                <img
                    src="{{ asset('storage/' . $user->foto) }}"
                    alt="Foto Profil {{ $user->nama }}"
                    class="w-full h-full object-cover"
                >
            @else
                <i class="fa-solid fa-user-shield"></i>
            @endif
        </div>
    </div>
</header>
