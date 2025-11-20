@extends('layouts.admin')

@section('content')
    <div class="flex min-h-screen bg-gray-50">
        <div class="flex-1 p-6">
            <div class="bg-[#B7E4FF] rounded-2xl shadow-md p-6 mt-6">
                <div class="bg-white rounded-2xl shadow-md p-8 mt-6">
                    <h2 class="text-xl font-semibold mb-2">Tambah Produk</h2>
                    <p class="text-sm text-gray-600 mb-6">Home > Produk > Tambah Produk</p>

                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                                <input type="text" name="nama_produk" class="w-full border rounded-md p-2" required>

                                <label class="block text-sm font-medium text-gray-700 mt-4 mb-1">Deskripsi</label>
                                <textarea name="deskripsi" rows="4" class="w-full border rounded-md p-2"></textarea>

                                <div class="grid grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                                        <select name="category_id" class="w-full border rounded-md p-2" required>
                                            <option value="">Pilih Kategori</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                                        <input type="number" name="stok" class="w-full border rounded-md p-2" required>
                                    </div>
                                </div>

                                <label class="block text-sm font-medium text-gray-700 mt-4 mb-1">Brand</label>
                                <input type="text" name="brand" class="w-full border rounded-md p-2">

                                <div class="mb-4 mt-4">
                                    <label class="block text-gray-700 font-bold mb-2">Harga Sewa</label>
                                    <input type="number" name="harga" class="w-full border rounded-md p-2" required>
                                </div>
                            </div>

                            <div class="flex justify-center items-center border-2 border-dashed border-gray-300 rounded-md p-6">
                                <div class="text-center">
                                    <img src="{{ asset('images/ph_image-light.png') }}" class="w-20 opacity-70 mx-auto">
                                    <p class="text-sm text-gray-500 mb-2">Upload gambar (JPEG/PNG)</p>
                                    <input type="file" name="gambar" class="block w-full text-sm text-gray-700">
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-center gap-4 mt-6">
                            <button type="submit" class="bg-pink-400 text-white px-6 py-2 rounded-md hover:bg-pink-500">Simpan</button>
                            <a href="{{ route('admin.products.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-300">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection