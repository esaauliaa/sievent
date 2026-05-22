<aside
    id="adminSidebar"
    class="fixed left-0 top-0 h-screen w-[245px] bg-[#0056B3] text-white flex flex-col shadow-2xl z-40 transform -translate-x-full transition-transform duration-300"
>
    <!-- Logo dan Close -->
    <div class="h-[120px] px-5 flex items-center justify-between border-b border-white/10">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center shadow-md">
                <img
                    src="{{ asset('images/logo-unej.png') }}"
                    alt="Logo Universitas Jember"
                    class="w-9 h-9 object-contain"
                >
            </div>

            <div>
                <h2 class="text-2xl font-extrabold tracking-wide">
                    SiEvent
                </h2>
                <p class="text-xs text-white/70">
                    Universitas Jember
                </p>
            </div>
        </div>

        <button
            type="button"
            onclick="closeSidebar()"
            class="w-9 h-9 rounded-xl bg-white/10 hover:bg-white/20 transition flex items-center justify-center"
        >
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <!-- Menu -->
    <nav class="flex-1 px-4 py-6 space-y-2">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}"
        class="flex items-center gap-3 px-4 py-3 rounded-2xl font-bold transition
        {{ request()->routeIs('admin.dashboard')
                ? 'bg-[#e1effe]/25 text-white shadow-md border border-white/20 backdrop-blur'
                : 'text-white/90 hover:bg-white/15' }}">
            <i class="fa-solid fa-chart-line w-5 text-sm"></i>
            <span>Dashboard</span>
        </a>

        <!-- Profil -->
        <a href="{{ route('profile.edit') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-2xl font-bold transition
            {{ request()->routeIs('profile.edit')
                ? 'bg-[#e1effe]/25 text-white shadow-md border border-white/20 backdrop-blur'
                : 'text-white/90 hover:bg-white/15' }}">
            <i class="fa-solid fa-user w-5 text-sm"></i>
            <span>Profil</span>
        </a>

        <!-- Ruangan -->
        <a href="{{ route('ruangan.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-2xl font-bold transition
            {{ request()->routeIs('ruangan.*')
                ? 'bg-[#e1effe]/25 text-white shadow-md border border-white/20 backdrop-blur'
                : 'text-white/90 hover:bg-white/15' }}">
            <i class="fa-solid fa-door-open w-5 text-sm"></i>
            <span>Ruangan</span>
        </a>

        <!-- Event -->
        <a href="#"
        class="flex items-center gap-3 px-4 py-3 rounded-2xl font-semibold text-white/90 hover:bg-white/15 transition">
            <i class="fa-solid fa-calendar-days w-5 text-sm"></i>
            <span>Event</span>
        </a>
    </nav>

    <!-- Logout -->
    <div class="p-4 border-t border-white/10">
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                class="w-full flex items-center justify-center gap-3 px-4 py-3 rounded-2xl bg-red-600 hover:bg-red-700 transition text-white font-extrabold shadow-lg">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>LOGOUT</span>
            </button>
        </form>
    </div>
</aside>
