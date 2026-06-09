<x-guest-layout>
    <div class="w-full max-w-[520px] mx-auto">
        <!-- Judul -->
        <div class="mb-8">
            <h1 class="text-[42px] leading-none font-extrabold text-[#1b3028] mb-4">
                Lupa Password
            </h1>

            <p class="text-[15px] leading-relaxed text-[#0056B3] font-medium max-w-[480px]">
                Masukkan email akun Anda. Kami akan mengirimkan link untuk mengatur ulang password Anda.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block mb-2 text-[13px] font-bold text-[#1b3028]">
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
                        autofocus
                        placeholder="Masukkan email akun Anda"
                        class="w-full h-[52px] pl-11 pr-4 text-[14px] rounded-xl border-2 border-[#0056B3] bg-[#e1effe] text-[#1b3028] placeholder:text-gray-600 focus:ring-1 focus:ring-[#0056B3] focus:border-[#0056B3]"
                    >
                </div>

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Button -->
            <div class="pt-4 flex justify-center">
                <button
                    type="submit"
                    class="w-[260px] h-[52px] rounded-2xl bg-[#0056B3] text-white text-[15px] font-extrabold hover:bg-[#131D4F] transition"
                >
                    KIRIM LINK
                </button>
            </div>

            <!-- Back to Login -->
            <div class="text-center text-[14px] font-bold text-[#1b3028]">
                Ingat password?
                <a href="{{ route('login') }}" class="underline hover:text-[#0056B3]">
                    Login sekarang
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
