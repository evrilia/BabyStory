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
</head>

<body class="bg-gray-50 font-sans antialiased">
    <div class="flex min-h-screen flex-col md:flex-row">

        {{-- Sidebar --}}
        <div id="sidebar"
            class="bg-white w-64 fixed md:relative z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out shadow-lg">
            @include('pages.admin.sidebar')
        </div>

        {{-- Main Area --}}
        <div class="flex-1 flex flex-col">
            {{-- Header --}}
            @include('pages.admin.header')

            {{-- Konten Utama --}}
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Script Toggle Sidebar (Mobile Friendly) --}}
    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
        }
    </script>

    {{-- AlpineJS --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>

</html>
