<footer class="mt-10 bg-[#131D4F] border-t border-[#0056B3]/30">
    <div class="px-6 lg:px-10 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Brand -->
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center">
                        <img
                            src="{{ asset('images/logo-unej.png') }}"
                            alt="Logo Universitas Jember"
                            class="w-9 h-9 object-contain"
                        >
                    </div>

                    <div>
                        <h3 class="text-xl font-extrabold text-white">
                            SiEvent
                        </h3>
                        <p class="text-sm text-white/70">
                            Universitas Jember
                        </p>
                    </div>
                </div>

                <p class="text-sm text-white/70 leading-relaxed max-w-md">
                    Sistem informasi event kampus yang memudahkan mahasiswa untuk
                    melihat ruangan, mencari event, mengikuti kegiatan, dan memantau jadwal event.
                </p>
            </div>

            <!-- Link Cepat -->
            <div class="md:flex md:justify-center">
                <div>
                    <h4 class="text-base font-extrabold text-white mb-4">
                        Link Cepat
                    </h4>

                    <div class="space-y-3 text-sm">
                        <a href="{{ route('dashboard') }}" class="block text-white/70 hover:text-white font-semibold transition">
                            Dashboard
                        </a>

                        <a href="{{ route('profile.edit') }}" class="block text-white/70 hover:text-white font-semibold transition">
                            Profil
                        </a>

                        <a href="{{ route('ruangan.index') }}" class="block text-white/70 hover:text-white font-semibold transition">
                            Ruangan
                        </a>

                        <a href="#" class="block text-white/70 hover:text-white font-semibold transition">
                            Event
                        </a>
                    </div>
                </div>
            </div>

            <!-- Kontak dan Sosial Media -->
            <div>
                <h4 class="text-base font-extrabold text-white mb-4">
                    Kontak & Sosial Media
                </h4>

                <div class="space-y-3 text-sm text-white/70">
                    <p class="flex items-center gap-3">
                        <i class="fa-solid fa-location-dot text-[#e1effe] w-4"></i>
                        Jl. Kalimantan No. 37, Kampus Tegalboto, Jember
                    </p>

                    <p class="flex items-center gap-3">
                        <i class="fa-solid fa-envelope text-[#e1effe] w-4"></i>
                        humas@unej.ac.id
                    </p>
                </div>

                <div class="flex items-center gap-3 mt-5">
                    <a
                        href="https://www.instagram.com/univ_jember"
                        target="_blank"
                        class="w-10 h-10 rounded-xl bg-white/10 text-white flex items-center justify-center hover:bg-white hover:text-[#0056B3] transition"
                        title="Instagram Universitas Jember"
                    >
                        <i class="fa-brands fa-instagram"></i>
                    </a>

                    <a
                        href="https://www.tiktok.com/@univ_jember"
                        target="_blank"
                        class="w-10 h-10 rounded-xl bg-white/10 text-white flex items-center justify-center hover:bg-white hover:text-[#0056B3] transition"
                        title="TikTok Universitas Jember"
                    >
                        <i class="fa-brands fa-tiktok"></i>
                    </a>

                    <a
                        href="https://www.youtube.com/@unejofficial"
                        target="_blank"
                        class="w-10 h-10 rounded-xl bg-white/10 text-white flex items-center justify-center hover:bg-white hover:text-[#0056B3] transition"
                        title="YouTube Universitas Jember"
                    >
                        <i class="fa-brands fa-youtube"></i>
                    </a>

                    <a
                        href="https://unej.ac.id"
                        target="_blank"
                        class="w-10 h-10 rounded-xl bg-white/10 text-white flex items-center justify-center hover:bg-white hover:text-[#0056B3] transition"
                        title="Website Universitas Jember"
                    >
                        <i class="fa-solid fa-globe"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="mt-8 pt-5 border-t border-white/10 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <p class="text-sm text-white/60">
                © 2026 SiEvent UNEJ. Semua hak cipta dilindungi.
            </p>

            <p class="text-sm font-bold text-white">
                Sistem Informasi Event Kampus Universitas Jember
            </p>
        </div>
    </div>
</footer>
