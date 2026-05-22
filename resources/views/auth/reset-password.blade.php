<x-guest-layout>
    <div class="w-full max-w-[520px] mx-auto">
        <!-- Judul -->
        <div class="mb-8">
            <h1 class="text-[42px] leading-none font-extrabold text-[#1b3028] mb-4">
                Reset Password
            </h1>

            <p class="text-[15px] leading-relaxed text-[#0056B3] font-medium max-w-[480px]">
                Buat password baru untuk akun Anda. Pastikan password mudah diingat dan tetap aman.
            </p>
        </div>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
            @csrf

            <!-- Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

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
                        value="{{ old('email', $request->email) }}"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="Masukkan email"
                        class="w-full h-[52px] pl-11 pr-4 text-[14px] rounded-xl border-2 border-[#0056B3] bg-[#e1effe] text-[#1b3028] placeholder:text-gray-600 focus:ring-1 focus:ring-[#0056B3] focus:border-[#0056B3]"
                    >
                </div>

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password Baru -->
            <div>
                <label for="password" class="block mb-2 text-[13px] font-bold text-[#1b3028]">
                    Password Baru
                </label>

                <div class="relative">
                    <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-[16px] text-[#4d5f5d]"></i>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        placeholder="Masukkan password baru"
                        class="w-full h-[52px] pl-11 pr-12 text-[14px] rounded-xl border-2 border-[#0056B3] bg-[#e1effe] text-[#1b3028] placeholder:text-gray-600 focus:ring-1 focus:ring-[#0056B3] focus:border-[#0056B3]"
                    >

                    <button
                        type="button"
                        onclick="togglePassword('password', 'eyePassword')"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-[#4d5f5d] hover:text-[#0056B3]"
                    >
                        <i id="eyePassword" class="fa-solid fa-eye text-[16px]"></i>
                    </button>
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="password_confirmation" class="block mb-2 text-[13px] font-bold text-[#1b3028]">
                    Konfirmasi Password
                </label>

                <div class="relative">
                    <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-[16px] text-[#4d5f5d]"></i>

                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Masukkan ulang password baru"
                        class="w-full h-[52px] pl-11 pr-12 text-[14px] rounded-xl border-2 border-[#0056B3] bg-[#e1effe] text-[#1b3028] placeholder:text-gray-600 focus:ring-1 focus:ring-[#0056B3] focus:border-[#0056B3]"
                    >

                    <button
                        type="button"
                        onclick="togglePassword('password_confirmation', 'eyePasswordConfirmation')"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-[#4d5f5d] hover:text-[#0056B3]"
                    >
                        <i id="eyePasswordConfirmation" class="fa-solid fa-eye text-[16px]"></i>
                    </button>
                </div>

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Button -->
            <div class="pt-4 flex justify-center">
                <button
                    type="submit"
                    class="w-[260px] h-[52px] rounded-2xl bg-[#0056B3] text-white text-[16px] font-extrabold hover:bg-[#131D4F] transition"
                >
                    RESET PASSWORD
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

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</x-guest-layout>
