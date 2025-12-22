<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard | Baby Story')</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        /* Mencegah overflow horizontal yang mengunci klik */
        body {
            overflow-x: hidden;
        }

        .main-content-wrapper {
            flex: 1;
            min-width: 0;
            position: relative;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased">
    <div class="flex min-h-screen">

        {{-- SIDEBAR: Dibuat lebih stabil agar tidak overlay ke konten utama --}}
        <aside id="sidebar"
            class="bg-white w-64 fixed md:sticky top-0 h-screen z-30 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out shadow-lg overflow-y-auto shrink-0">
            @include('pages.admin.sidebar')
        </aside>

        {{-- Overlay untuk Mobile saja (Muncul saat sidebar terbuka di HP) --}}
        <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-20 hidden md:hidden"></div>

        {{-- MAIN CONTENT WRAPPER --}}
        <div class="main-content-wrapper flex flex-col">

            {{-- HEADER: Turunkan z-index agar tidak menutupi dropdown sidebar --}}
            <header class="sticky top-0 z-20 bg-white">
                @include('pages.admin.header')
            </header>

            {{-- AREA FORM / KONTEN --}}
            <main class="p-6 relative">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('sidebarToggle');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            });
        }

        // Tutup sidebar jika klik di area gelap (Mobile)
        overlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    </script>
</body>

</html>