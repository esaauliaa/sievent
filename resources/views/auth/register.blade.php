<x-guest-layout>
    <div class="w-full max-w-[520px] mx-auto">
        <!-- Judul -->
        <div class="mb-6">
            <h1 class="text-[46px] leading-none font-extrabold text-[#1b3028] mb-4">
                Register
            </h1>

            <p class="text-[15px] leading-relaxed text-[#0056B3] font-medium max-w-[480px]">
                Buat akun Anda untuk mengelola dan mengikuti event kampus
                Universitas Jember melalui SiEvent.
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-3">
            @csrf

            <!-- Nama Lengkap -->
            <div>
                <label for="nama" class="block mb-1.5 text-[13px] font-bold text-[#1b3028]">
                    Nama Lengkap
                </label>

                <div class="relative">
                    <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-[16px] text-[#4d5f5d]"></i>

                    <input
                        id="nama"
                        type="text"
                        name="nama"
                        value="{{ old('nama') }}"
                        required
                        autofocus
                        placeholder="Masukkan nama lengkap"
                        class="w-full h-[48px] pl-11 pr-4 text-[14px] rounded-xl border-2 border-[#0056B3] bg-[#e1effe] text-[#1b3028] placeholder:text-gray-600 focus:ring-1 focus:ring-[#0056B3] focus:border-[#0056B3]"
                    >
                </div>

                <x-input-error :messages="$errors->get('nama')" class="mt-1" />
            </div>

            <!-- NIM -->
            <div>
                <label for="nim" class="block mb-1.5 text-[13px] font-bold text-[#1b3028]">
                    NIM
                </label>

                <div class="relative">
                    <i class="fa-solid fa-id-card absolute left-4 top-1/2 -translate-y-1/2 text-[16px] text-[#4d5f5d]"></i>

                    <input
                        id="nim"
                        type="text"
                        name="nim"
                        value="{{ old('nim') }}"
                        maxlength="12"
                        placeholder="Wajib untuk mahasiswa, 12 digit angka"
                        class="w-full h-[48px] pl-11 pr-4 text-[14px] rounded-xl border-2 border-[#0056B3] bg-[#e1effe] text-[#1b3028] placeholder:text-gray-600 focus:ring-1 focus:ring-[#0056B3] focus:border-[#0056B3]"
                    >
                </div>

                <x-input-error :messages="$errors->get('nim')" class="mt-1" />
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block mb-1.5 text-[13px] font-bold text-[#1b3028]">
                    Email
                </label>

                <div class="relative">
                    <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-[16px] text-[#4d5f5d]"></i>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        placeholder="Masukkan email"
                        class="w-full h-[48px] pl-11 pr-4 text-[14px] rounded-xl border-2 border-[#0056B3] bg-[#e1effe] text-[#1b3028] placeholder:text-gray-600 focus:ring-1 focus:ring-[#0056B3] focus:border-[#0056B3]"
                    >
                </div>

                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <!-- Role -->
            <div>
                <label class="block mb-1.5 text-[13px] font-bold text-[#1b3028]">
                    Role
                </label>

                <div class="grid grid-cols-2 gap-3">
                    <label class="cursor-pointer">
                        <input
                            type="radio"
                            name="role"
                            value="mahasiswa"
                            class="peer hidden"
                            {{ old('role') == 'mahasiswa' ? 'checked' : '' }}
                            required
                        >

                        <div class="h-[48px] flex items-center gap-3 px-4 rounded-xl border-2 border-[#0056B3] bg-[#e1effe] text-[#1b3028] peer-checked:bg-[#cfe7ff] peer-checked:ring-1 peer-checked:ring-[#0056B3]">
                            <i class="fa-solid fa-user-graduate text-[17px] text-[#4d5f5d]"></i>
                            <span class="text-[14px] font-medium">Mahasiswa</span>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input
                            type="radio"
                            name="role"
                            value="penyelenggara"
                            class="peer hidden"
                            {{ old('role') == 'penyelenggara' ? 'checked' : '' }}
                            required
                        >

                        <div class="h-[48px] flex items-center gap-3 px-4 rounded-xl border-2 border-[#0056B3] bg-[#e1effe] text-[#1b3028] peer-checked:bg-[#cfe7ff] peer-checked:ring-1 peer-checked:ring-[#0056B3]">
                            <i class="fa-solid fa-user-gear text-[17px] text-[#4d5f5d]"></i>
                            <span class="text-[14px] font-medium">Penyelenggara</span>
                        </div>
                    </label>
                </div>

                <x-input-error :messages="$errors->get('role')" class="mt-1" />
            </div>

            <!-- Nomor Telepon -->
            <div>
                <label for="no_telpon" class="block mb-1.5 text-[13px] font-bold text-[#1b3028]">
                    Nomor Telepon
                </label>

                <div class="relative">
                    <i class="fa-solid fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-[16px] text-[#4d5f5d]"></i>

                    <input
                        id="no_telpon"
                        type="text"
                        name="no_telpon"
                        value="{{ old('no_telpon') }}"
                        required
                        placeholder="Masukkan nomor telepon"
                        class="w-full h-[48px] pl-11 pr-4 text-[14px] rounded-xl border-2 border-[#0056B3] bg-[#e1effe] text-[#1b3028] placeholder:text-gray-600 focus:ring-1 focus:ring-[#0056B3] focus:border-[#0056B3]"
                    >
                </div>

                <x-input-error :messages="$errors->get('no_telpon')" class="mt-1" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block mb-1.5 text-[13px] font-bold text-[#1b3028]">
                    Password
                </label>

                <div class="relative">
                    <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-[16px] text-[#4d5f5d]"></i>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        placeholder="Masukkan password"
                        class="w-full h-[48px] pl-11 pr-4 text-[14px] rounded-xl border-2 border-[#0056B3] bg-[#e1effe] text-[#1b3028] placeholder:text-gray-600 focus:ring-1 focus:ring-[#0056B3] focus:border-[#0056B3]"
                    >
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="password_confirmation" class="block mb-1.5 text-[13px] font-bold text-[#1b3028]">
                    Konfirmasi Password
                </label>

                <div class="relative">
                    <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-[16px] text-[#4d5f5d]"></i>

                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        placeholder="Masukkan ulang password"
                        class="w-full h-[48px] pl-11 pr-4 text-[14px] rounded-xl border-2 border-[#0056B3] bg-[#e1effe] text-[#1b3028] placeholder:text-gray-600 focus:ring-1 focus:ring-[#0056B3] focus:border-[#0056B3]"
                    >
                </div>

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>

            <!-- Button -->
            <div class="pt-3 flex justify-center">
                <button
                    type="submit"
                    class="w-[260px] h-[52px] rounded-2xl bg-[#0056B3] text-white text-[17px] font-extrabold hover:bg-[#131D4F] transition"
                >
                    REGISTER
                </button>
            </div>

            <!-- Login Link -->
            <div class="text-center text-[14px] font-bold text-[#1b3028]">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="underline hover:text-[#0056B3]">
                    Login sekarang
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
