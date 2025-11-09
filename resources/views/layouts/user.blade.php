<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baby Story | Collect Memories Not Things</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    @vite('resources/css/app.css')
</head>

<body class="bg-white text-gray-800">

    {{-- Navbar --}}
    @include('pages.user.components.navbar')

    {{-- Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('pages.user.components.footer')

</body>

</html>
