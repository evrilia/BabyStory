@extends('layouts.admin')

@section('content')
    <div class="p-6">
        <div class="bg-white rounded-2xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-[#0077B6] mb-2">Detail Produk</h2>
            <p class="text-sm text-gray-500 mb-6">Home > Produk > Detail Produk</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-[#D2EEFF] p-6 rounded-2xl">

                <!-- Info Produk -->
                <div class="flex flex-col gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Nama Produk</label>
                        <input type="text" value="{{ $product->nama_produk }}" class="w-full border rounded-md p-2"
                            readonly>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Deskripsi</label>
                        <textarea class="w-full border rounded-md p-2 h-28" readonly>{{ $product->deskripsi }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Kategori</label>
                        <input type="text" value="{{ $product->kategori->nama ?? '-' }}"
                            class="w-full border rounded-md p-2" readonly>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Brand</label>
                        <input type="text" value="{{ $product->brand }}" class="w-full border rounded-md p-2" readonly>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Stok</label>
                        <input type="text" value="{{ $product->stok }}" class="w-full border rounded-md p-2" readonly>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Harga Rental</label>
                        <input type="text" value="Rp {{ number_format($product->harga_rental, 0, ',', '.') }}"
                            class="w-full border rounded-md p-2" readonly>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex gap-4 mt-4">
                        <a href="{{ route('admin.products.edit', $product->id) }}"
                            class="bg-[#8fd4ff] hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded-full shadow transition duration-300 ease-in-out">
                            UPDATE
                        </a>

                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-pink-300 hover:bg-pink-500 text-white font-semibold px-6 py-2 rounded-full shadow transition duration-300 ease-in-out">
                                DELETE
                            </button>
                        </form>

                        <a href="{{ route('admin.products.index') }}"
                            class="relative z-10 bg-gray-200 text-gray-700 px-6 py-2 rounded-full hover:bg-gray-300">
                            CANCEL
                        </a>
                    </div>
                </div>

                <!-- Gambar Produk -->
                <div class="flex justify-center items-start">
                    <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}"
                        class="rounded-lg shadow-md w-64 h-64 object-cover border">
                </div>
            </div>
        </div>
    </div>
@endsection
