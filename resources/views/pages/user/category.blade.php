@extends('layouts.user')

@section('title', 'Kategori Produk | Baby Story')

@section('content')
    <div class="min-h-screen bg-gray-50 pb-16">

        {{-- Hero Header --}}
        <section class="relative w-full h-64 bg-gradient-to-r from-blue-100 via-pink-100 to-blue-200 flex flex-col justify-center items-center text-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Koleksi Produk Sewa</h1>
                <p class="text-lg text-pink-600 font-medium">Temukan perlengkapan bayi terbaik sesuai kebutuhan.</p>
            </div>
        </section>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid grid-cols-1 lg:grid-cols-4 gap-8">

            {{-- Sidebar --}}
            <aside class="lg:col-span-1 hidden lg:block">
                <div class="bg-white p-6 rounded-2xl shadow-lg sticky top-24 border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-3">Kategori</h2>
                    <ul class="space-y-2">
                        {{-- Link Semua Kategori --}}
                         <li>
                            <a href="{{ url('/category/all') }}" class="block px-4 py-2 rounded-lg hover:bg-pink-50 hover:text-pink-600 transition">
                                Semua Produk
                            </a>
                        </li>
                        @foreach ($categories as $cat)
                            @php
                                $isActive = isset($category) && $category->id == $cat->id;
                            @endphp
                            <li>
                                <a href="{{ route('category.show', $cat->id) }}"
                                    class="flex justify-between px-4 py-2 rounded-lg transition 
                                    {{ $isActive ? 'bg-pink-500 text-white' : 'text-gray-700 hover:bg-pink-50' }}">
                                    <span>{{ $cat->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            {{-- Product Grid --}}
            <main class="lg:col-span-3">
                @if ($products->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach ($products as $product)
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:scale-[1.02] transition border border-gray-100">
                                <a href="{{ route('product.show', $product->id) }}" class="block">
                                    {{-- Gambar --}}
                                    <div class="w-full h-48 flex items-center justify-center p-4 bg-gray-50">
                                        {{-- PERBAIKAN: Gunakan 'gambar' --}}
                                        <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}"
                                            class="h-full w-full object-contain"
                                            onerror="this.onerror=null; this.src='{{ asset('images/ph_image-light.png') }}';">
                                    </div>

                                    <div class="p-4">
                                        <p class="text-xs font-semibold uppercase text-gray-400 mb-1">
                                            {{ $product->kategori ?? 'Produk' }}
                                        </p>
                                        {{-- PERBAIKAN: Gunakan 'nama_produk' --}}
                                        <h3 class="text-base font-semibold text-gray-900 truncate mb-2">{{ $product->nama_produk }}</h3>
                                        
                                        <div class="flex justify-between items-center mt-3">
                                            {{-- PERBAIKAN: Gunakan 'harga' --}}
                                            <span class="text-xl font-extrabold text-pink-600">
                                                Rp.{{ number_format($product->harga, 0, ',', '.') }}
                                            </span>
                                            {{-- PERBAIKAN: Gunakan 'stok' --}}
                                            <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-0.5 rounded-full">
                                                Stok: {{ $product->stok }}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                     <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-10 bg-white rounded-xl shadow">
                        <p class="text-gray-500">Belum ada produk di kategori ini.</p>
                    </div>
                @endif
            </main>
        </div>
    </div>
@endsection