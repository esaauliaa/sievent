<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Mahasiswa - SiEvent UNEJ')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans bg-[#f4f9ff] text-[#1b3028]">
    <div class="min-h-screen flex">

        <!-- Overlay Sidebar -->
        <div
            id="sidebarOverlay"
            onclick="closeSidebar()"
            class="fixed inset-0 bg-black/40 z-30 hidden"
        ></div>

        <!-- Sidebar -->
        @include('partials.mahasiswa.sidebar')

        <!-- Main Content -->
        <div class="flex-1 min-h-screen flex flex-col">

            <!-- Header -->
            @include('partials.mahasiswa.header')

            <!-- Isi Halaman -->
            <main class="flex-1 p-6 lg:p-8">
                @yield('content')
            </main>

            <!-- Footer -->
            @include('partials.mahasiswa.footer')

        </div>
    </div>

    <script>
        function openSidebar() {
            document.getElementById('mahasiswaSidebar').classList.remove('-translate-x-full');
            document.getElementById('sidebarOverlay').classList.remove('hidden');
        }

        function closeSidebar() {
            document.getElementById('mahasiswaSidebar').classList.add('-translate-x-full');
            document.getElementById('sidebarOverlay').classList.add('hidden');
        }
    </script>
</body>
</html>
