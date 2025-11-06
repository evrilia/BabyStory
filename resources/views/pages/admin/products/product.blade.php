@extends('layouts.admin')

@section('content')
    <div class="flex min-h-screen bg-gray-50">
        <div class="flex-1 p-6">

            <div class="bg-[#B7E4FF] rounded-2xl shadow-md p-6 mt-6">

                <!-- Header + Tombol Tambah Produk -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Produk</h2>
                        <p class="text-sm text-gray-600">Home > Produk</p>
                    </div>
                    <a href="{{ route('admin.products.create') }}"
                        class="bg-pink-400 text-white px-4 py-2 rounded-full hover:bg-pink-500">
                        + Tambah Produk
                    </a>
                </div>

                <!-- Grid Produk -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse ($products as $product)
                        <a href="{{ route('admin.products.show', $product->id) }}">
                            <div class="bg-white rounded-xl shadow p-4 text-center hover:shadow-lg transition">
                                <!-- Gambar Produk -->
                                <div
                                    class="w-full h-48 bg-pink-200 rounded-lg flex items-center justify-center overflow-hidden mb-3">
                                    @if ($product->gambar)
                                        <img src="{{ asset('storage/' . $product->gambar) }}"
                                            alt="{{ $product->nama_produk }}" class="object-contain w-full h-full">
                                    @else
                                        <img src="{{ asset('images/ph_image-light.png') }}" alt="Placeholder"
                                            class="w-20 opacity-70">
                                    @endif
                                </div>

                                <!-- Nama & Kategori Produk -->
                                <h3 class="font-semibold text-gray-700 text-sm mb-1">
                                    {{ $product->kategori ?? 'Tanpa Kategori' }} - {{ $product->nama_produk }}
                                </h3>
                                <p class="text-gray-600 text-xs">Stok: {{ $product->stok }}</p>
                            </div>
                        </a>
                    @empty
                        <p class="col-span-full text-center text-gray-600">Belum ada produk</p>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-6 flex justify-center">
                    {{ $products->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection
