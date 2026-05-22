<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SiEvent UNEJ</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2 bg-white">

        <!-- LEFT SIDE -->
        <div class="relative hidden lg:flex items-center overflow-hidden min-h-screen">

            <!-- Background image UNEJ -->
            <div
                class="absolute inset-0"
                style="
                    background-image: url('{{ asset('images/unej-bg.jpg') }}');
                    background-repeat: no-repeat;
                    background-size: cover;
                    background-position: center 58%;
                    transform: scale(1.06);
                    transform-origin: center;
                "
            ></div>

            <!-- Overlay putih -->
            <div class="absolute inset-0 bg-white/18"></div>

            <!-- Gradasi putih -->
            <div
                class="absolute inset-0"
                style="
                    background: linear-gradient(
                        90deg,
                        rgba(255,255,255,0.58) 0%,
                        rgba(255,255,255,0.48) 32%,
                        rgba(255,255,255,0.35) 58%,
                        rgba(255,255,255,0.72) 82%,
                        rgba(255,255,255,1) 100%
                    );
                "
            ></div>

            <!-- Fade putih kanan -->
            <div
                class="absolute inset-y-0 right-0 w-[420px]"
                style="
                    background: linear-gradient(
                        90deg,
                        rgba(255,255,255,0) 0%,
                        rgba(255,255,255,0.35) 35%,
                        rgba(255,255,255,0.78) 70%,
                        rgba(255,255,255,1) 100%
                    );
                "
            ></div>

            <!-- Fade biru bawah -->
            <div class="absolute inset-x-0 bottom-0 h-52 bg-gradient-to-t from-[#0056B3]/25 to-transparent"></div>

            <!-- Konten kiri -->
            <div class="relative z-10 w-full px-16">
                <div
                    class="max-w-[520px] text-[#1b3028]"
                    style="transform: translateY(-90px);"
                >
                    <div class="mb-6">
                        <i class="fa-solid fa-graduation-cap" style="font-size: 34px;"></i>
                    </div>

                    <h1
                        class="font-extrabold mb-6"
                        style="font-size: 38px; line-height: 1.2;"
                    >
                        Welcome to SiEvent
                    </h1>

                    <p
                        class="font-medium"
                        style="font-size: 16px; line-height: 1.8;"
                    >
                        Platform pengelolaan event kampus Universitas Jember
                        yang membantu proses pengajuan, pendaftaran, presensi,
                        dan pengelolaan kegiatan secara terpusat.
                    </p>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div
            class="min-h-screen flex items-start justify-center px-6 py-10 lg:px-14"
            style="
                background: linear-gradient(
                    90deg,
                    #ffffff 0%,
                    #ffffff 24%,
                    #f8fcff 42%,
                    #f0f8ff 62%,
                    #e8f4ff 82%,
                    #e1effe 100%
                );
            "
        >
            <div class="w-full max-w-[520px]">
                {{ $slot }}
            </div>
        </div>

    </div>
</body>
</html>
