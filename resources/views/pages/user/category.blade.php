@extends('layouts.user')

@section('title', 'Kategori Produk | Baby Story')

@section('content')
    {{-- Main Content Container --}}
    <div class="min-h-screen bg-gray-50 pb-16">

        {{-- 1. Hero & Header --}}
        <section
            class="relative w-full h-64 bg-gradient-to-r from-blue-100 via-pink-100 to-blue-200 flex flex-col justify-center items-center text-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Koleksi Produk Sewa</h1>
                <p class="text-lg text-pink-600 font-medium">
                    Temukan perlengkapan bayi terbaik sesuai kategori pilihan Anda.
                </p>
                {{-- Breadcrumb (Optional, but good for UX) --}}
                <div class="mt-4 text-sm text-gray-500">
                    {{-- Ganti rute home jika namanya berbeda di routes/web.php --}}
                    <a href="{{ route('user.home') }}" class="hover:underline">Beranda</a> / Kategori
                </div>
            </div>
        </section>

        

        {{-- 2. Sidebar & Product Grid Container --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid grid-cols-1 lg:grid-cols-4 gap-8">

            {{-- A. Sidebar Kategori (Desktop) --}}
            <aside class="lg:col-span-1 hidden lg:block">
                <div class="bg-white p-6 rounded-2xl shadow-lg sticky top-24 border border-gray-100">
                    <h2
                        class="text-xl font-bold text-gray-800 mb-6 text-center border-b border-gray-200 pb-3 tracking-wide">
                        Kategori
                    </h2>
                    <ul class="space-y-2 text-base">

                        @foreach ($categories as $category)
                            @php
                                // Mengecek apakah kategori saat ini aktif
                                $isActive = isset($current_category) && $current_category->id == $category->id;
                                $routeParams = ['id' => $category->id];
                            @endphp

                            <li>
                                {{-- Pastikan rute 'category.show' sesuai --}}
                                <a href="{{ route('category.show', $routeParams) }}"
                                    class="flex items-center justify-between w-full px-4 py-3 rounded-lg font-medium transition duration-200 
                        {{ $isActive
                            ? 'bg-pink-500 text-white shadow-md ring-2 ring-pink-300'
                            : 'text-gray-700 hover:bg-pink-50 hover:text-pink-600 hover:shadow-sm' }}">
                                    <span class="truncate">{{ $category->name }}</span>

                                    {{-- Icon aktif --}}
                                    @if ($isActive)
                                        <i class="fas fa-check-circle text-white text-sm"></i>
                                    @endif
                                </a>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </aside>


            {{-- B. Daftar Produk (Main Content) --}}
            <main class="lg:col-span-3">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">
                    @if (isset($current_category))
                        Produk Kategori: <span class="text-pink-600">{{ $current_category->name }}</span>
                    @else
                        Semua Produk
                    @endif
                </h2>

                {{-- Mobile Dropdown for Categories --}}
                <div class="mb-6 lg:hidden">
                    <label for="mobile-category" class="sr-only">Pilih Kategori</label>
                    <select id="mobile-category" onchange="window.location.href=this.value"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 text-lg p-3">

                        {{-- PERBAIKAN: Mengganti route('category.index') dengan URL base. --}}
                        <option value="/category" {{ !isset($current_category) ? 'selected' : '' }}>Semua Kategori</option>

                        @foreach ($categories as $category)
                            <option value="{{ route('category.show', ['id' => $category->id]) }}"
                                {{ isset($current_category) && $current_category->id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Product Grid --}}
                @if ($products->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach ($products as $product)
                            <div
                                class="bg-white rounded-xl shadow-lg overflow-hidden transition duration-300 hover:shadow-xl hover:scale-[1.02] border border-gray-100">
                                <a href="{{ route('product.show', ['id' => $product->id]) }}" class="block">
                                    {{-- Product Image Area --}}
                                    <div
                                        class="w-full h-48 flex items-center justify-center p-4 {{ $loop->index % 2 == 0 ? 'bg-blue-50' : 'bg-pink-50' }}">
                                        {{-- Catatan: Pastikan $product->image memiliki path yang valid di storage --}}
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                            class="h-full w-full object-contain transition duration-500 hover:scale-105"
                                            onerror="this.onerror=null; this.src='https://placehold.co/400x400/eeeeee/333333?text=Gambar+Kosong';">
                                    </div>

                                    {{-- Product Info --}}
                                    <div class="p-4">
                                        {{-- Asumsi Anda memiliki kolom category_name pada produk atau Anda bisa mengaksesnya --}}
                                        <p class="text-xs font-semibold uppercase text-gray-400 mb-1">
                                            {{ $product->category_name ?? 'Alat Bayi' }}
                                        </p>
                                        <h3 class="text-base font-semibold text-gray-900 truncate mb-2"
                                            title="{{ $product->name }}">
                                            {{ $product->name }}
                                        </h3>

                                        {{-- Price and Status --}}
                                        <div class="flex justify-between items-center mt-3">
                                            <span class="text-xl font-extrabold text-pink-600">
                                                Rp.{{ number_format($product->price ?? 0, 0, ',', '.') }}
                                            </span>
                                            <span
                                                class="text-xs font-medium text-green-600 bg-green-100 px-2 py-0.5 rounded-full">
                                                Stok: {{ $product->stock ?? '?' }}
                                            </span>
                                        </div>
                                    </div>
                                </a>

                                {{-- Action Button (Sewa) --}}
                                <div class="p-4 pt-0">
                                    <a href="{{ route('product.show', ['id' => $product->id]) }}"
                                        class="mt-2 w-full block text-center bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 rounded-lg text-sm transition transform hover:shadow-md">
                                        Lihat & Sewa
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="bg-white p-10 rounded-xl shadow-lg text-center mt-8">
                        {{-- Menggunakan Font Awesome (pastikan sudah di-load di layout) --}}
                        <i class="far fa-box-open text-6xl text-gray-300 mb-4"></i>
                        <p class="text-xl font-medium text-gray-700">Oops, belum ada produk tersedia.</p>
                        <p class="text-gray-500 mt-2">Coba kategori lain atau kembali sebentar lagi!</p>
                    </div>
                @endif

                <div class="flex justify-center mt-10">
                    {{ $products->links() }}
                </div>
            </main>
        </div>
    </div>


@endsection
