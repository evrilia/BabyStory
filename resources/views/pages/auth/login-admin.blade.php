<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Baby Story</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 flex justify-center items-center min-h-screen font-sans">

    <div class="w-[900px] h-[500px] bg-white shadow-2xl rounded-xl flex overflow-hidden">

        <!-- Bagian kiri -->
        <div class="w-1/2 bg-[#B7E4FF] flex flex-col justify-center items-center ">
            <img src="{{ asset('images/LogoBaby.png') }}" alt="Logo Baby" class="w-40 mb-4">
        </div>

        <!-- Bagian kanan (Form Login) -->
        <div class="w-1/2 flex flex-col justify-center px-12 relative">
            <h2 class="text-3xl font-bold mb-2 text-gray-800">Welcome, Admin 👋</h2>
            <p class="text-sm text-gray-600 mb-6">Silakan masuk untuk mengelola sistem Baby Story</p>

            <!-- Pesan error -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded-lg mb-4">
                    {{ $errors->first('login_error') }}
                </div>
            @endif

            <!-- Form Login -->
            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="username" class="block text-sm font-semibold text-gray-700 mb-1">Username</label>
                    <input type="text" id="username" name="username" required value="{{ old('username') }}"
                        class="w-full border border-gray-300 rounded-full px-4 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none"
                        placeholder="Masukkan username anda">
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full border border-gray-300 rounded-full px-4 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none"
                        placeholder="Masukkan password anda">
                </div>

                <button type="submit"
                    class="w-full bg-pink-400 text-white py-2 rounded-full font-semibold hover:bg-pink-500 transition duration-200">
                    Login
                </button>
            </form>

            <!-- Catatan kecil di bawah -->
            <p class="text-xs text-gray-400 text-center mt-6">
                © {{ date('Y') }} Baby Story — Admin Panel
            </p>
        </div>
    </div>

</body>

</html>
