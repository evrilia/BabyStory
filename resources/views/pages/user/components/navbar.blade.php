<nav class="absolute top-0 left-0 w-full py-4 px-6 flex justify-between items-center bg-transparent z-50">
    <a href="{{ route('user.home') }}" class="flex items-center space-x-2">
        <img src="{{ asset('images/LogoBaby.png') }}" alt="Logo Baby Story" class="h-30 w-auto">
    </a>
    <ul class="flex gap-6 text-white font-medium drop-shadow">
        <li><a href="{{ route('user.home') }}" class="hover:text-pink-300 transition">Beranda</a></li>
        <li><a href="#kategori" class="hover:text-pink-300 transition">Kategori</a></li>
        <li><a href="#syarat" class="hover:text-pink-300 transition">Syarat & Ketentuan</a></li>
        <li><a href="#layanan" class="hover:text-pink-300 transition">Layanan Komunikasi</a></li>
    </ul>
</nav>
