<x-guest-layout>
    <div class="w-full max-w-[520px] mx-auto">
        <!-- Judul -->
        <div class="mb-8">
            <h1 class="text-[46px] leading-none font-extrabold text-[#1b3028] mb-4">
                Login
            </h1>

            <p class="text-[15px] leading-relaxed text-[#0056B3] font-medium max-w-[480px]">
                Masuk ke akun Anda untuk mengelola dan mengikuti event
                kampus Universitas Jember melalui SiEvent.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email atau NIM -->
            <div>
                <label for="login" class="block mb-2 text-[13px] font-bold text-[#1b3028]">
                    Email atau NIM
                </label>

                <div class="relative">
                    <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-[16px] text-[#4d5f5d]"></i>

                    <input
                        id="login"
                        type="text"
                        name="login"
                        value="{{ old('login') }}"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="Masukkan email atau NIM"
                        class="w-full h-[52px] pl-11 pr-4 text-[14px] rounded-xl border-2 border-[#0056B3] bg-[#e1effe] text-[#1b3028] placeholder:text-gray-600 focus:ring-1 focus:ring-[#0056B3] focus:border-[#0056B3]"
                    >
                </div>

                <x-input-error :messages="$errors->get('login')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block mb-2 text-[13px] font-bold text-[#1b3028]">
                    Password
                </label>

                <div class="relative">
                    <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-[16px] text-[#4d5f5d]"></i>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="Masukkan password"
                        class="w-full h-[52px] pl-11 pr-4 text-[14px] rounded-xl border-2 border-[#0056B3] bg-[#e1effe] text-[#1b3028] placeholder:text-gray-600 focus:ring-1 focus:ring-[#0056B3] focus:border-[#0056B3]"
                    >
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me dan Lupa Password -->
            <div class="flex items-center justify-between pt-1">
                <label for="remember_me" class="flex items-center gap-2 cursor-pointer">
                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                        class="w-4 h-4 rounded border-2 border-[#0056B3] text-[#0056B3] focus:ring-[#0056B3]"
                    >

                    <span class="text-[14px] font-bold text-[#0056B3]">
                        Remember Me
                    </span>
                </label>

                @if (Route::has('password.request'))
                    <a
                        href="{{ route('password.request') }}"
                        class="text-[14px] font-bold text-[#0056B3] underline hover:text-[#131D4F]"
                    >
                        Lupa Password
                    </a>
                @endif
            </div>

            <!-- Button -->
            <div class="pt-5 flex justify-center">
                <button
                    type="submit"
                    class="w-[260px] h-[52px] rounded-2xl bg-[#0056B3] text-white text-[17px] font-extrabold hover:bg-[#131D4F] transition"
                >
                    LOGIN
                </button>
            </div>

            <!-- Register Link -->
            <div class="text-center text-[14px] font-bold text-[#1b3028]">
                Belum punya akun?
                <a href="{{ route('register') }}" class="underline hover:text-[#0056B3]">
                    Register sekarang
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
