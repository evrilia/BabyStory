@extends('layouts.admin')

@section('content')
    <div class="p-6">
        <div class="bg-white rounded-2xl shadow-md p-6 border">
            <h2 class="text-lg font-semibold text-[#0077B6] mb-2">Edit Produk</h2>
            <p class="text-sm text-gray-500 mb-6">Home > Produk > Edit Produk</p>

            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Nama Produk</label>
                        <input type="text" name="nama_produk" value="{{ $product->nama_produk }}"
                            class="w-full border rounded-md p-2">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Kategori</label>
                        <input type="text" name="kategori" value="{{ $product->kategori }}"
                            class="w-full border rounded-md p-2">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Brand</label>
                        <input type="text" name="brand" value="{{ $product->brand }}"
                            class="w-full border rounded-md p-2">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Stok</label>
                        <input type="number" name="stok" value="{{ $product->stok }}"
                            class="w-full border rounded-md p-2">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Harga Rental</label>
                        <input type="number" name="harga_rental" value="{{ $product->harga_rental }}"
                            class="w-full border rounded-md p-2">
                    </div>

                    <div class="col-span-full">
                        <label class="block text-sm font-semibold mb-1">Deskripsi</label>
                        <textarea name="deskripsi" class="w-full border rounded-md p-2 h-28">{{ $product->deskripsi }}</textarea>
                    </div>

                    <div class="col-span-full">
                        <label class="block text-sm font-semibold mb-1">Gambar</label>
                        <input type="file" name="gambar" class="w-full border rounded-md p-2">
                    </div>
                </div>

                <div class="flex gap-3 mt-4">
                    <button type="submit"
                        class="bg-[#0077B6] text-white px-6 py-2 rounded-full hover:bg-[#005A8D]">UPDATE</button>
                    <a href="{{ route('admin.products.index') }}"
                        class="bg-gray-200 text-gray-700 px-6 py-2 rounded-full hover:bg-gray-300">CANCEL</a>
                </div>
            </form>
        </div>
    </div>
@endsection
