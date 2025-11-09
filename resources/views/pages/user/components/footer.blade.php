<footer id="layanan" class="bg-white py-10 text-gray-700">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">

            {{-- Kolom Kiri: Deskripsi & Media Sosial --}}
            <div class="flex flex-col items-start mb-6 md:mb-0">
                <p class="text-base text-black mb-2">
                    Kami membantu
                </p>
                <p class="text-base text-black mb-4">
                    kenyamanan si kecil
                </p>
                {{-- Tombol komunikasi (Ikon Saja) --}}
                <div class="flex gap-3">
                    {{-- Instagram --}}
                    <a href="https://instagram.com/babystory_pbg" target="_blank"
                        class="border border-gray-300 w-8 h-8 flex items-center justify-center rounded-full hover:border-pink-500 transition">
                        <img src="{{ asset('images/iconig.png') }}" alt="Instagram Icon" class="h-4 w-4">
                    </a>
                    {{-- WhatsApp --}}
                    <a href="https://wa.me/6281575851730" target="_blank"
                        class="border border-gray-300 w-8 h-8 flex items-center justify-center rounded-full hover:border-green-500 transition">
                        <img src="{{ asset('images/iconwa.png') }}" alt="WhatsApp Icon" class="h-4 w-4">
                    </a>
                </div>
            </div>

            {{-- Kolom Tengah: Logo --}}
            <div class="flex justify-center mb-6 md:mb-0">
                {{-- Perhatikan bahwa logo diubah menjadi LogoBabyWhite.png --}}
                <img src="{{ asset('images/LogoBaby.png') }}" alt="Logo Baby Story" class="h-28 w-auto">
            </div>

            {{-- Kolom Kanan: Informasi Navigasi --}}
            <div class="flex flex-col items-start md:items-end">
                <p class="text-base font-bold text-black mb-4">
                    Informasi
                </p>
                <p class="text-base text-black mb-2">Tentang Kami</p>
                <p class="text-base text-black">Produk</p>
                {{-- Navigasi footer --}}
                {{-- <a href="{{ route('user.about') ?? '#' }}" class="text-base hover:text-pink-500 transition mb-2">Tentang
                    Kami</a>
                <a href="{{ route('user.products') ?? '#' }}"
                    class="text-base hover:text-pink-500 transition">Produk</a> --}}
            </div>

        </div>

        {{-- Bagian Bawah: Copyright dan T&C --}}
        {{-- Menggunakan teks hak cipta yang lebih panjang sesuai gambar --}}
        <div class="text-center text-sm text-gray-500">
            © 2024 Baby Island. All Rights Reserved |
            <a href="#terms" class="hover:text-pink-500 transition">Terms of Use</a> |
            <a href="#privacy" class="hover:text-pink-500 transition">Privacy Policy</a>
        </div>
    </div>
</footer>
