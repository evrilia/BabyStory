<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Baby Story</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex font-sans">

    <!-- Bagian kiri -->
    <div class="w-1/2 bg-[#B7E4FF] flex flex-col justify-center items-center relative rounded-r-[100px]">

        <img src="{{ asset('images/LogoBabyWhite.png') }}" alt="Logo Baby" class="w-150 z-10 mb-4">
    </div>

    <!-- Bagian kanan -->
    <div class="w-1/2 flex flex-col justify-center px-24">
        <div class="max-w-md w-full mx-auto">
            <h2 class="text-3xl font-bold mb-3 text-gray-800 text-center">WELCOME</h2>
            <p class="text-sm text-gray-600 mb-8 text-center">Selamat datang, Admin! Silakan masuk untuk<br>melanjutkan
                tugas Anda.</p>

            <!-- Pesan error -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded-lg mb-4 text-center">
                    {{ $errors->first('login_error') }}
                </div>
            @endif

            <!-- Form Login -->
            <form action="{{ route('admin.login') }}" method="POST" autocomplete="off">
                @csrf

                <div class="mb-4">
                    <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
                    <input type="text" name="username" id="username" placeholder="Masukkan username Anda"
                        class="w-full px-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-pink-300 
                         placeholder:text-sm  placeholder:text-gray-400 "
                        autocomplete="off">

                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" id="password" placeholder="Masukkan password Anda"
                        class="w-full px-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-pink-300
                        placeholder:text-sm  placeholder:text-gray-400 "
                        autocomplete="new-password">
                </div>

                <button type="submit"
                    class="w-full bg-pink-400 hover:bg-pink-500 text-white font-bold py-2 rounded-full transition">
                    Login
                </button>
            </form>


            <p class="text-xs text-gray-400 text-center mt-6">
                © {{ date('Y') }} Baby Story — Admin Panel
            </p>
        </div>
    </div>

</body>

</html>
