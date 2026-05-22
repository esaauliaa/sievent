@extends('layouts.' . Auth::user()->role)

@section('title', 'Profil Saya - SiEvent UNEJ')

@section('page-title', 'Profil Saya')

@section('content')
    <div class="max-w-5xl mx-auto">
        <!-- Header Profil -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-[#0056B3] to-[#131D4F] rounded-3xl p-8 text-white shadow-lg relative overflow-hidden">
                <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full translate-x-20 -translate-y-20"></div>
                <div class="absolute right-24 bottom-0 w-32 h-32 bg-white/10 rounded-full translate-y-16"></div>

                <div class="relative z-10 flex flex-col md:flex-row md:items-center gap-6">
                    <!-- Preview Foto Profil -->
                    <div class="w-24 h-24 rounded-3xl bg-white/20 border border-white/30 flex items-center justify-center overflow-hidden">
                        @if (Auth::user()->foto)
                            <img
                                id="profileCardFoto"
                                src="{{ asset('storage/' . Auth::user()->foto) }}"
                                alt="Foto Profil"
                                class="w-full h-full object-cover"
                            >
                        @else
                            <img
                                id="profileCardFoto"
                                src=""
                                alt="Foto Profil"
                                class="hidden w-full h-full object-cover"
                            >

                            <i id="profileCardDefaultIcon" class="fa-solid fa-user text-4xl"></i>
                        @endif
                    </div>

                    <div>
                        <h2 class="text-3xl font-extrabold">
                            {{ Auth::user()->nama }}
                        </h2>

                        <p class="text-white/80 mt-1">
                            {{ Auth::user()->email }}
                        </p>

                        <div class="flex flex-wrap items-center gap-3 mt-3">
                            <span class="inline-flex px-4 py-1 rounded-full bg-white/20 text-sm font-bold capitalize">
                                {{ Auth::user()->role }}
                            </span>

                            @if (Auth::user()->nim)
                                <span class="inline-flex px-4 py-1 rounded-full bg-white/20 text-sm font-bold">
                                    NIM: {{ Auth::user()->nim }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert sukses -->
        @if (session('status'))
            <div class="mb-6 p-4 rounded-2xl bg-green-100 text-green-700 font-bold">
                {{ session('status') }}
            </div>
        @endif

        <!-- Form Profil -->
        <div class="bg-white rounded-3xl border border-blue-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-blue-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h3 class="text-lg font-extrabold text-[#131D4F]">
                        Edit Profil
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Perbarui informasi profil dan password akun Anda.
                    </p>
                </div>

                <button
                    type="submit"
                    form="profileForm"
                    class="w-full md:w-auto px-6 py-3 rounded-2xl bg-[#0056B3] text-white font-extrabold hover:bg-[#131D4F] transition shadow-md"
                >
                    <i class="fa-solid fa-floppy-disk mr-2"></i>
                    Simpan Semua Perubahan
                </button>
            </div>

            <form
                id="profileForm"
                method="POST"
                action="{{ route('profile.update') }}"
                enctype="multipart/form-data"
                class="px-6 pt-4 pb-6 space-y-6"
            >
                @csrf
                @method('PATCH')

                <!-- Foto Profil -->
                <div class="rounded-2xl border border-blue-100 bg-[#f8fbff] p-5">
                    <h4 class="text-base font-extrabold text-[#131D4F] mb-4">
                        Foto Profil
                    </h4>

                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                        <label
                            for="foto"
                            class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-[#0056B3] text-white font-bold cursor-pointer hover:bg-[#131D4F] transition shadow-sm"
                        >
                            <i class="fa-solid fa-image mr-2"></i>
                            Choose File
                        </label>

                        <span id="fileNameText" class="text-sm text-gray-500">
                            No file chosen
                        </span>
                    </div>

                    <input
                        id="foto"
                        type="file"
                        name="foto"
                        accept="image/*"
                        class="hidden"
                    >

                    <input
                        id="cropped_foto"
                        type="hidden"
                        name="cropped_foto"
                    >

                    <p class="text-xs text-gray-500 mt-2">
                        Format: JPG, JPEG, PNG, WEBP. Maksimal 2MB.
                    </p>

                    <x-input-error :messages="$errors->get('foto')" class="mt-3" />
                    <x-input-error :messages="$errors->get('cropped_foto')" class="mt-3" />
                </div>

                <!-- Data Profil -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama -->
                    <div>
                        <label for="nama" class="block mb-2 text-sm font-bold text-[#1b3028]">
                            Nama Lengkap
                        </label>

                        <div class="relative">
                            <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-[#4d5f5d]"></i>

                            <input
                                id="nama"
                                type="text"
                                name="nama"
                                value="{{ old('nama', Auth::user()->nama) }}"
                                required
                                placeholder="Masukkan nama lengkap"
                                class="w-full h-[52px] pl-11 pr-4 text-sm rounded-xl border-2 border-[#0056B3] bg-[#e1effe] text-[#1b3028] placeholder:text-gray-500 focus:ring-1 focus:ring-[#0056B3] focus:border-[#0056B3]"
                            >
                        </div>

                        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block mb-2 text-sm font-bold text-[#1b3028]">
                            Email
                        </label>

                        <div class="relative">
                            <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-[#4d5f5d]"></i>

                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email', Auth::user()->email) }}"
                                required
                                placeholder="Masukkan email"
                                class="w-full h-[52px] pl-11 pr-4 text-sm rounded-xl border-2 border-[#0056B3] bg-[#e1effe] text-[#1b3028] placeholder:text-gray-500 focus:ring-1 focus:ring-[#0056B3] focus:border-[#0056B3]"
                            >
                        </div>

                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- NIM -->
                    <div>
                        <label for="nim" class="block mb-2 text-sm font-bold text-[#1b3028]">
                            NIM
                        </label>

                        <div class="relative">
                            <i class="fa-solid fa-id-card absolute left-4 top-1/2 -translate-y-1/2 text-[#4d5f5d]"></i>

                            <input
                                id="nim"
                                type="text"
                                name="nim"
                                maxlength="12"
                                value="{{ old('nim', Auth::user()->nim) }}"
                                placeholder="Wajib untuk mahasiswa, 12 digit angka"
                                class="w-full h-[52px] pl-11 pr-4 text-sm rounded-xl border-2 border-[#0056B3] bg-[#e1effe] text-[#1b3028] placeholder:text-gray-500 focus:ring-1 focus:ring-[#0056B3] focus:border-[#0056B3]"
                            >
                        </div>

                        <x-input-error :messages="$errors->get('nim')" class="mt-2" />

                        @if (Auth::user()->role !== 'mahasiswa')
                            <p class="text-xs text-gray-500 mt-2">
                                NIM boleh dikosongkan untuk akun admin atau penyelenggara.
                            </p>
                        @endif
                    </div>

                    <!-- Nomor Telepon -->
                    <div>
                        <label for="no_telpon" class="block mb-2 text-sm font-bold text-[#1b3028]">
                            Nomor Telepon
                        </label>

                        <div class="relative">
                            <i class="fa-solid fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-[#4d5f5d]"></i>

                            <input
                                id="no_telpon"
                                type="text"
                                name="no_telpon"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                value="{{ old('no_telpon', Auth::user()->no_telpon) }}"
                                placeholder="Masukkan nomor telepon"
                                class="w-full h-[52px] pl-11 pr-4 text-sm rounded-xl border-2 border-[#0056B3] bg-[#e1effe] text-[#1b3028] placeholder:text-gray-500 focus:ring-1 focus:ring-[#0056B3] focus:border-[#0056B3]"
                            >
                        </div>

                        <x-input-error :messages="$errors->get('no_telpon')" class="mt-2" />
                    </div>
                </div>

                <!-- Role -->
                <div>
                    <label class="block mb-2 text-sm font-bold text-[#1b3028]">
                        Role
                    </label>

                    <div class="relative">
                        <i class="fa-solid fa-user-tag absolute left-4 top-1/2 -translate-y-1/2 text-[#4d5f5d]"></i>

                        <input
                            type="text"
                            value="{{ ucfirst(Auth::user()->role) }}"
                            disabled
                            class="w-full h-[52px] pl-11 pr-4 text-sm rounded-xl border-2 border-gray-200 bg-gray-100 text-gray-500 cursor-not-allowed"
                        >
                    </div>

                    <p class="text-xs text-gray-500 mt-2">
                        Role tidak dapat diubah melalui halaman profil.
                    </p>
                </div>

                <!-- Reset Password -->
                <div class="pt-6 border-t border-blue-100">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-1">
                            <h4 class="text-xl font-extrabold text-[#131D4F] mb-2">
                                Reset Password
                            </h4>

                            <p class="text-sm text-gray-500 leading-relaxed">
                                Gunakan bagian ini jika Anda ingin mengganti password akun.
                                Kosongkan jika tidak ingin mengubah password.
                            </p>

                            <div class="mt-5 p-4 rounded-2xl bg-[#e1effe] border border-blue-100 text-sm text-[#131D4F]">
                                <i class="fa-solid fa-circle-info mr-2 text-[#0056B3]"></i>
                                Password baru minimal 8 karakter.
                            </div>
                        </div>

                        <div class="lg:col-span-2 space-y-5">
                            <!-- Password Lama -->
                            <div>
                                <label for="current_password" class="block mb-2 text-sm font-bold text-[#1b3028]">
                                    Password Lama
                                </label>

                                <div class="relative">
                                    <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-[#4d5f5d]"></i>

                                    <input
                                        id="current_password"
                                        type="password"
                                        name="current_password"
                                        placeholder="Masukkan password lama"
                                        class="w-full h-[52px] pl-11 pr-12 text-sm rounded-xl border-2 border-[#0056B3] bg-[#e1effe] text-[#1b3028] placeholder:text-gray-500 focus:ring-1 focus:ring-[#0056B3] focus:border-[#0056B3]"
                                    >

                                    <button
                                        type="button"
                                        onclick="togglePassword('current_password', 'eyeCurrentPassword')"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-[#4d5f5d] hover:text-[#0056B3]"
                                    >
                                        <i id="eyeCurrentPassword" class="fa-solid fa-eye text-[16px]"></i>
                                    </button>
                                </div>

                                <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                            </div>

                            <!-- Password Baru -->
                            <div>
                                <label for="password" class="block mb-2 text-sm font-bold text-[#1b3028]">
                                    Password Baru
                                </label>

                                <div class="relative">
                                    <i class="fa-solid fa-key absolute left-4 top-1/2 -translate-y-1/2 text-[#4d5f5d]"></i>

                                    <input
                                        id="password"
                                        type="password"
                                        name="password"
                                        placeholder="Masukkan password baru"
                                        class="w-full h-[52px] pl-11 pr-12 text-sm rounded-xl border-2 border-[#0056B3] bg-[#e1effe] text-[#1b3028] placeholder:text-gray-500 focus:ring-1 focus:ring-[#0056B3] focus:border-[#0056B3]"
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

                            <!-- Konfirmasi Password Baru -->
                            <div>
                                <label for="password_confirmation" class="block mb-2 text-sm font-bold text-[#1b3028]">
                                    Konfirmasi Password Baru
                                </label>

                                <div class="relative">
                                    <i class="fa-solid fa-key absolute left-4 top-1/2 -translate-y-1/2 text-[#4d5f5d]"></i>

                                    <input
                                        id="password_confirmation"
                                        type="password"
                                        name="password_confirmation"
                                        placeholder="Masukkan ulang password baru"
                                        class="w-full h-[52px] pl-11 pr-12 text-sm rounded-xl border-2 border-[#0056B3] bg-[#e1effe] text-[#1b3028] placeholder:text-gray-500 focus:ring-1 focus:ring-[#0056B3] focus:border-[#0056B3]"
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
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Crop Foto -->
    <div
        id="cropModal"
        class="fixed inset-0 z-[999] hidden items-center justify-center bg-black/60 px-4"
    >
        <div class="w-full max-w-3xl rounded-3xl bg-white shadow-2xl overflow-hidden">
            <div class="px-6 py-5 border-b border-blue-100 flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-extrabold text-[#131D4F]">
                        Sesuaikan Foto Profil
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Geser atau zoom foto agar posisi wajah terlihat pas.
                    </p>
                </div>

                <button
                    type="button"
                    onclick="closeCropModal()"
                    class="w-10 h-10 rounded-xl bg-gray-100 text-gray-600 hover:bg-red-100 hover:text-red-600 transition"
                >
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="p-6">
                <div class="w-full h-[420px] bg-[#e1effe] rounded-2xl overflow-hidden flex items-center justify-center">
                    <img
                        id="cropImage"
                        src=""
                        alt="Crop Foto"
                        class="max-w-full max-h-full"
                    >
                </div>

                <div class="mt-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex flex-wrap items-center gap-3">
                        <button
                            type="button"
                            onclick="zoomCrop(0.1)"
                            class="px-4 py-2 rounded-xl bg-[#e1effe] text-[#0056B3] font-bold hover:bg-blue-100 transition"
                        >
                            <i class="fa-solid fa-magnifying-glass-plus mr-1"></i>
                            Zoom
                        </button>

                        <button
                            type="button"
                            onclick="zoomCrop(-0.1)"
                            class="px-4 py-2 rounded-xl bg-[#e1effe] text-[#0056B3] font-bold hover:bg-blue-100 transition"
                        >
                            <i class="fa-solid fa-magnifying-glass-minus mr-1"></i>
                            Kecilkan
                        </button>

                        <button
                            type="button"
                            onclick="resetCrop()"
                            class="px-4 py-2 rounded-xl bg-gray-100 text-gray-700 font-bold hover:bg-gray-200 transition"
                        >
                            Reset
                        </button>
                    </div>

                    <div class="flex items-center gap-3">
                        <button
                            type="button"
                            onclick="closeCropModal()"
                            class="px-6 py-3 rounded-2xl bg-gray-100 text-gray-700 font-bold hover:bg-gray-200 transition"
                        >
                            Batal
                        </button>

                        <button
                            type="button"
                            onclick="useCroppedImage()"
                            class="px-6 py-3 rounded-2xl bg-[#0056B3] text-white font-extrabold hover:bg-[#131D4F] transition shadow-md"
                        >
                            Gunakan Foto
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css"
    >

    <style>
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }

        .cropper-view-box,
        .cropper-face {
            border-radius: 50%;
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

    <script>
        let cropper = null;

        const fotoInput = document.getElementById('foto');
        const fileNameText = document.getElementById('fileNameText');
        const cropModal = document.getElementById('cropModal');
        const cropImage = document.getElementById('cropImage');
        const croppedFotoInput = document.getElementById('cropped_foto');
        const profileCardFoto = document.getElementById('profileCardFoto');
        const profileCardDefaultIcon = document.getElementById('profileCardDefaultIcon');

        fotoInput.addEventListener('change', function (event) {
            const file = event.target.files[0];

            fileNameText.textContent = file ? file.name : 'No file chosen';

            if (!file) {
                return;
            }

            if (!file.type.startsWith('image/')) {
                alert('File harus berupa gambar.');
                fotoInput.value = '';
                fileNameText.textContent = 'No file chosen';
                return;
            }

            const reader = new FileReader();

            reader.onload = function (e) {
                cropImage.src = e.target.result;

                cropModal.classList.remove('hidden');
                cropModal.classList.add('flex');

                if (cropper) {
                    cropper.destroy();
                }

                cropper = new Cropper(cropImage, {
                    aspectRatio: 1,
                    viewMode: 1,
                    dragMode: 'move',
                    autoCropArea: 0.85,
                    responsive: true,
                    background: false,
                    movable: true,
                    zoomable: true,
                    rotatable: false,
                    scalable: false,
                    cropBoxMovable: false,
                    cropBoxResizable: false,
                });
            };

            reader.readAsDataURL(file);
        });

        function closeCropModal() {
            cropModal.classList.add('hidden');
            cropModal.classList.remove('flex');

            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        }

        function zoomCrop(value) {
            if (cropper) {
                cropper.zoom(value);
            }
        }

        function resetCrop() {
            if (cropper) {
                cropper.reset();
            }
        }

        function useCroppedImage() {
            if (!cropper) {
                return;
            }

            const canvas = cropper.getCroppedCanvas({
                width: 400,
                height: 400,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            const croppedImageData = canvas.toDataURL('image/png');

            croppedFotoInput.value = croppedImageData;

            profileCardFoto.src = croppedImageData;
            profileCardFoto.classList.remove('hidden');

            if (profileCardDefaultIcon) {
                profileCardDefaultIcon.classList.add('hidden');
            }

            closeCropModal();
        }

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
@endsection
