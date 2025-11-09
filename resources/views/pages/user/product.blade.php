@extends('layouts.user')

{{-- Tentukan judul halaman --}}
@section('title', 'Detail ' . $product->nama_produk)

@section('content')
    {{-- Bagian Utama Produk --}}
    <section class="bg-gray-50 min-h-screen py-20 md:py-20 mt-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Card Utama Konten --}}
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden transition duration-300 hover:shadow-3xl">
                <div class="grid lg:grid-cols-2 gap-0">

                    {{-- 1. Area Gambar Produk --}}
                    <div class="bg-blue-50 flex items-center justify-center p-40 lg:p-12">
                        <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}"
                            class="w-full max-w-sm md:max-w-md h-auto object-contain rounded-2xl shadow-xl border-4 border-white transform transition duration-500 hover:scale-105">
                    </div>

                    {{-- 2. Detail & Aksi Produk --}}
                    <div class="p-8 md:p-12 flex flex-col justify-between">
                        <div>
                            {{-- Nama Produk --}}
                            <h1 class="text-4xl font-extrabold text-gray-900 mb-2 leading-tight">
                                {{ $product->nama_produk }}
                            </h1>

                            {{-- Kategori & Status --}}
                            <div class="flex items-center space-x-4 mb-6 text-sm">
                                <span
                                    class="text-pink-600 font-semibold uppercase tracking-wider bg-pink-100 px-3 py-1 rounded-full">
                                    {{ $product->kategori ?? 'Kategori Tidak Diketahui' }}
                                </span>
                                <span class="text-green-600 font-medium">
                                    <i class="fas fa-check-circle mr-1"></i> Stok Tersedia
                                </span>
                            </div>

                            {{-- Divider --}}
                            <div class="border-t border-gray-200 my-6"></div>

                            {{-- Harga Sewa --}}
                            <div class="mb-8">
                                <p class="text-xl font-bold text-gray-800 mb-4">Pilihan Harga Sewa:</p>
                                <ul class="space-y-3">
                                    <li
                                        class="flex justify-between items-center bg-gray-100 p-4 rounded-xl border border-gray-200 shadow-sm">
                                        <span class="font-medium text-gray-700">Per Minggu</span>
                                        <span class="text-2xl font-extrabold text-pink-600">
                                            Rp.{{ number_format($product->harga, 0, ',', '.') }}
                                        </span>
                                    </li>
                                    {{-- Tambahkan opsi harga lain jika ada (contoh dummy) --}}
                                    {{--
                                    <li class="flex justify-between items-center bg-gray-100 p-4 rounded-xl border border-gray-200 shadow-sm">
                                        <span class="font-medium text-gray-700">Per Bulan</span>
                                        <span class="text-2xl font-extrabold text-blue-600">
                                            Rp.{{ number_format($product->harga * 3, 0, ',', '.') }}
                                        </span>
                                    </li>
                                    --}}
                                </ul>
                            </div>

                            {{-- Ketersediaan Stok --}}
                            <p class="text-lg text-gray-700 mb-6 font-medium">
                                Stok Tersisa: <span class="font-bold text-blue-600">{{ $product->stok }} unit</span>
                            </p>
                        </div>

                        {{-- Tombol Aksi (Diperbarui ke Link WhatsApp) --}}
                        <div class="mt-8">
                            @php
                                // Mengganti spasi, enter, dan karakter khusus dengan %20 untuk URL-safe
                                $whatsapp_message = urlencode(
                                    'Halo, saya tertarik untuk menyewa produk: ' .
                                        $product->nama_produk .
                                        ' (ID Produk: ' .
                                        $product->id .
                                        '). Mohon info ketersediaan dan prosedur selanjutnya.',
                                );
                                $whatsapp_number = '6281575851730'; // Ganti dengan nomor WhatsApp Anda
                                $whatsapp_link = "https://wa.me/{$whatsapp_number}?text={$whatsapp_message}";
                            @endphp

                            <a href="{{ $whatsapp_link }}" target="_blank"
                                class="w-full block text-center bg-pink-500 hover:bg-pink-600 text-white font-extrabold text-xl py-4 rounded-2xl shadow-lg transition transform hover:scale-[1.01] hover:shadow-xl focus:ring-4 focus:ring-pink-300">
                                <i class="fab fa-whatsapp mr-2"></i> Sewa Sekarang via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Deskripsi Produk --}}
            <div class="mt-12 bg-white p-8 md:p-12 rounded-3xl shadow-xl border-t-4 border-pink-500">
                <h3 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-3 flex items-center">
                    <i class="fas fa-file-alt text-blue-500 mr-3"></i> Deskripsi Lengkap Produk
                </h3>

                {{-- Konten Deskripsi --}}
                <div class="text-gray-700 space-y-5 leading-relaxed text-base md:text-lg whitespace-pre-wrap">
                    {{-- Menggunakan {!! nl2br(e(...)) !!} untuk mempertahankan baris baru dari database --}}
                    {!! nl2br(e($product->deskripsi)) !!}
                </div>
            </div>

            {{-- Tombol Kembali --}}
            <div class="mt-10 text-center">
                <a href="{{ route('user.home') }}"
                    class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Halaman Utama
                </a>
            </div>
        </div>
    </section>
@endsection
