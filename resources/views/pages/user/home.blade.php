@extends('layouts.user')

@section('content')
    {{-- Hero Section --}}
    <section class="relative w-full h-screen bg-cover bg-center flex flex-col justify-center items-center text-gray-800"
        style="background-image: url('{{ asset('images/background.png') }}');">
        <div class="relative text-center px-4">
        </div>
    </section>


    {{-- Mengapa Baby Story --}}
    <section class="py-16 bg-white text-center">
        <h2 class="text-3xl font-extrabold mb-3 text-gray-800">Kenapa Memilih Baby Story?</h2>
        <p class="text-gray-600 mb-12 max-w-3xl mx-auto text-lg">
            Mendukung perjalanan si kecil dengan penyewaan premium, keamanan terjamin, dan solusi keluarga dari Baby Story.
        </p>

        {{-- Kartu Keunggulan (Grid 4 Kolom) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-6xl mx-auto px-4">

            {{-- Keunggulan 1: 250+ Item Koleksi (Menggunakan koleksi.png) --}}
            <div class="p-6 transform hover:shadow-xl transition duration-300">
                <img src="{{ asset('images/itemkoleksi.png') }}" alt="250+ Item Koleksi"
                    class="w-100 h-100 mx-auto mb-4 object-contain">
            </div>

            {{-- Keunggulan 2: Bersih & Steril (Menggunakan ikon placeholder) --}}
            <div class="p-6 transform hover:shadow-xl transition duration-300">
                <img src="{{ asset('images/berish.png') }}" alt="bersih steril"
                    class="w-100 h-100 mx-auto mb-4 object-contain">
            </div>

            {{-- Keunggulan 3: Delivery Service (Menggunakan ikon placeholder) --}}
            <div class="p-6  transform hover:shadow-xl transition duration-300">
                <img src="{{ asset('images/delivery.png') }}" alt="delivery service"
                    class="w-100 h-100 mx-auto mb-4 object-contain">
            </div>

            {{-- Keunggulan 4: Good Maintenance (Menggunakan ikon placeholder) --}}
            <div class="p-6 transform hover:shadow-xl transition duration-300">
                <img src="{{ asset('images/maintenance.png') }}" alt="maintenance"
                    class="w-100 h-100 mx-auto mb-4 object-contain">
            </div>

        </div>
    </section>

    {{-- Kategori --}}
    <section id="kategori"
        class="py-12 bg-gradient-to-b from-white via-blue-200 to-white p-8 text-white rounded-lg shadow-xl text-center">
        <h2 class="text-3xl font-bold mb-8 text-gray-800">✨ Kategori Produk</h2>

        {{-- Container utama untuk grid (max-w-6xl mx-auto mengatur lebar maksimum dan rata tengah) --}}
        <div class="grid grid-cols-2 gap-6 max-w-6xl mx-auto px-4 sm:grid-cols-3 md:grid-cols-4 lg:gap-8">

            @foreach ($categories->take(12) as $category)
                <div
                    class="bg-white shadow-lg rounded-xl p-4 transform hover:scale-105 transition duration-300 ease-in-out cursor-pointer group">
                    {{-- Tambahkan tautan jika kategori perlu diklik --}}
                    <a href="{{ route('category.show', ['id' => $category->id]) }}">
                        {{-- <a href="{{ route('user.category', ['slug' => $category->slug]) }}"> --}}
                        <img src="{{ asset('storage/' . $category->image) }}"
                            class="w-full h-40 object-cover rounded-lg mb-3 group-hover:opacity-90 transition-opacity"
                            alt="{{ $category->name }}">
                        <h3 class="font-semibold text-lg text-gray-700 mt-2 truncate">{{ $category->name }}</h3>
                    </a>
                </div>
            @endforeach

        </div>
    </section>

    {{-- Bagian Syarat dan Ketentuan --}}
    <section id="syarat"
        class="py-12 px-4 bg-gradient-to-b from-white via-pink-200 to-white p-8 text-white rounded-lg shadow-xl">
        <div class="max-w-4xl mx-auto bg-pink-100 p-8 md:p-10 rounded-lg shadow-lg">

            {{-- Judul --}}
            <h2 class="text-2xl md:text-3xl font-bold text-center text-gray-800 mb-8 py-3 bg-pink-300 rounded-md">
                Syarat dan Ketentuan Penyewaan Baby Story
            </h2>

            {{-- Isi Konten --}}
            <ol class="list-none space-y-6 text-gray-800 text-base leading-relaxed">

                {{-- 1. Umum --}}
                <li>
                    <h3 class="font-bold text-lg mb-2 text-pink-700">1. Umum</h3>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Dengan menggunakan layanan Baby Island, pelanggan dianggap telah membaca dan menyetujui syarat &
                            ketentuan ini.</li>
                        <li>Baby Island berhak mengubah ketentuan tanpa pemberitahuan sebelumnya.</li>
                    </ul>
                </li>

                {{-- 2. Penyewaan & Penggunaan --}}
                <li>
                    <h3 class="font-bold text-lg mb-2 text-pink-700">2. Penyewaan & Penggunaan</h3>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Pemesanan hanya dapat dilakukan via chat admin melalui WhatsApp.</li>
                        <li>Pelanggan harus memilih tanggal sewa dengan benar.</li>
                        <li>Produk yang disewa hanya untuk penggunaan pribadi, bukan untuk diperjualbelikan atau disewakan
                            kembali.</li>
                        <li>Barang harus dikembalikan dalam kondisi yang sama seperti saat diterima.</li>
                    </ul>
                </li>

                {{-- 3. Pembayaran --}}
                <li>
                    <h3 class="font-bold text-lg mb-2 text-pink-700">3. Pembayaran</h3>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Pembayaran dilakukan sebelum barang dikirim atau diambil.</li>
                        <li>Bukti pembayaran harus diunggah untuk verifikasi pesanan.</li>
                        <li>Tidak ada pengembalian dana setelah transaksi selesai, kecuali dalam kondisi tertentu yang
                            disetujui Baby Story.</li>
                    </ul>
                </li>

                {{-- 4. Pengiriman & Pengembalian --}}
                <li>
                    <h3 class="font-bold text-lg mb-2 text-pink-700">4. Pengiriman & Pengembalian</h3>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Pelanggan bertanggung jawab atas biaya pengiriman dan pengembalian (jika berlaku).</li>
                        <li>Keterlambatan pengembalian akan dikenakan biaya tambahan sesuai kebijakan.</li>
                        <li>Jika produk mengalami kerusakan atau hilang, pelanggan wajib mengganti sesuai nilai yang
                            ditetapkan.</li>
                    </ul>
                </li>

                {{-- 5. Pembatalan & Perubahan Pesanan --}}
                <li>
                    <h3 class="font-bold text-lg mb-2 text-pink-700">5. Pembatalan & Perubahan Pesanan</h3>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Pembatalan dapat dilakukan sebelum pesanan dikonfirmasi dan dana akan dikembalikan dengan
                            potongan biaya administrasi.</li>
                        <li>Perubahan tanggal sewa dapat dilakukan dengan menghubungi layanan pelanggan terlebih dahulu.
                        </li>
                    </ul>
                </li>

                {{-- 6. Tanggung Jawab Pelanggan --}}
                <li>
                    <h3 class="font-bold text-lg mb-2 text-pink-700">6. Tanggung Jawab Pelanggan</h3>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Pelanggan bertanggung jawab penuh atas produk selama masa sewa.</li>
                        <li>Baby Story tidak bertanggung jawab atas kecelakaan atau cedera yang terjadi akibat penggunaan
                            produk yang disewa.</li>
                    </ul>
                </li>

            </ol>

        </div>
    </section>

    {{-- Bagian Layanan Komunikasi --}}
    <section id="layanan" class="py-16 px-4 bg-gradient-to-b from-white via-blue-200 to-blue-200 p-8 text-center ">

        {{-- Kontainer internal untuk membatasi lebar konten agar rata tengah --}}
        <div class="max-w-4xl mx-auto">

            {{-- Judul (Diperbesar: text-2xl md:text-3xl) --}}
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4 tracking-wider">
                Layanan Komunikasi Kami
            </h2>

            {{-- Deskripsi (Diperbesar: text-lg) --}}
            <p class="text-lg text-gray-700 max-w-2xl mx-auto mb-8 leading-relaxed">
                Jika ada pertanyaan atau ingin konsultasi sebelum menyewa, jangan ragu untuk menghubungi kami. Admin kami
                siap membalas pertanyaan Anda dengan baik.
            </p>

            {{-- Tombol Chat --}}
            <a href="https://wa.me/6281575851730" target="_blank"
                class="inline-block bg-white text-gray-800 font-semibold py-3 px-8 rounded-md shadow-md hover:bg-gray-100 transition duration-300 uppercase tracking-widest">
                Chat
            </a>

        </div>
    </section>
@endsection
