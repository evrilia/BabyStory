<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard | Baby Story')</title>

    {{-- Tailwind & Vite --}}
    @vite('resources/css/app.css')

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-uWj+RCL4iDhXgDq8x6Q0U1C8F9FT6nD7j9v8yqZQ2rG6ZbW0p1Ku+gZAEI2EQdb8/1QKzGmYxS3pL7ZpP1x9w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Select2 CSS (Untuk Searchable Dropdown di Form Order) --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- Style Tambahan Global --}}
    <style>
        /* Fix Select2 agar tinggi sama dengan input Tailwind */
        .select2-container .select2-selection--single {
            height: 42px !important;
            border: 1px solid #d1d5db !important;
            border-radius: 0.5rem !important;
            display: flex;
            align-items: center;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased">
    <div class="flex min-h-screen flex-col md:flex-row">

        {{-- SIDEBAR (Sticky) --}}
        {{-- Perubahan: md:relative jadi md:sticky, ditambah top-0 dan h-screen --}}
        <aside id="sidebar"
            class="bg-white w-64 fixed md:sticky md:top-0 md:h-screen z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out shadow-lg overflow-y-auto shrink-0">

            {{-- Include File Sidebar --}}
            @include('pages.admin.sidebar')
        </aside>

        {{-- MAIN CONTENT --}}
        <div class="flex-1 flex flex-col min-w-0">

            {{-- HEADER (Sticky) --}}
            {{-- Perubahan: Ditambah div sticky top-0 agar header juga ikut diam di atas --}}
            <div class="sticky top-0 z-40">
                @include('pages.admin.header')
            </div>

            {{-- ISI KONTEN --}}
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Script Toggle Sidebar (Untuk Tampilan HP) --}}
    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');

        // Cek element agar tidak error
        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
        }

        // Klik luar sidebar untuk menutup (Mobile)
        document.addEventListener('click', (e) => {
            if (window.innerWidth < 768) {
                if (!sidebar.contains(e.target) && !toggleBtn?.contains(e.target) && !sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.add('-translate-x-full');
                }
            }
        });
    </script>

    {{-- AlpineJS --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>

</html>