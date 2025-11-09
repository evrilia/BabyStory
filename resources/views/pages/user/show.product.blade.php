@extends('layouts.user')

@section('content')
    <div class="max-w-6xl mx-auto py-10 px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}"
                    class="w-full h-96 object-cover rounded-lg shadow-md">
            </div>

            <div>
                <h2 class="text-3xl font-bold text-gray-800 mb-2">{{ $product->nama_produk }}</h2>
                <p class="text-gray-500 mb-4">{{ $product->kategori }}</p>
                <p class="text-2xl font-semibold text-pink-600 mb-6">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                <p class="text-gray-700 leading-relaxed mb-6">{{ $product->deskripsi }}</p>

                <div class="flex items-center gap-4">
                    <span class="text-gray-600">Stok: {{ $product->stok }}</span>
                    <button
                        class="bg-gradient-to-r from-pink-400 to-blue-400 text-white px-6 py-2 rounded-lg shadow hover:opacity-90 transition">
                        Sewa Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
