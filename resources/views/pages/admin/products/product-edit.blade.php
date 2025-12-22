@extends('layouts.admin')

@section('content')
    <div class="p-6">
        <div class="bg-white rounded-2xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-[#0077B6] mb-2">Edit Produk</h2>
            <p class="text-sm text-gray-500 mb-6">Home > Produk > Edit Produk</p>

            {{-- Form Action ke Update --}}
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-[#D2EEFF] p-6 rounded-2xl">
                    
                    <div class="flex flex-col gap-4">
                        <div>
                            <label class="block text-sm font-semibold mb-1">Nama Produk</label>
                            <input type="text" name="nama_produk" value="{{ old('nama_produk', $product->nama_produk) }}" 
                                   class="w-full border rounded-md p-2 bg-white" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-1">Deskripsi</label>
                            <textarea name="deskripsi" class="w-full border rounded-md p-2 h-28 bg-white">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-1">Kategori</label>
                            <select name="category_id" class="w-full border rounded-md p-2 bg-white" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-1">Brand</label>
                            <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" 
                                   class="w-full border rounded-md p-2 bg-white">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-1">Stok</label>
                            <input type="number" name="stok" value="{{ old('stok', $product->stok) }}" 
                                   class="w-full border rounded-md p-2 bg-white" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-1">Harga Rental</label>
                            <input type="number" name="harga" value="{{ old('harga', $product->harga) }}" 
                                   class="w-full border rounded-md p-2 bg-white" required>
                        </div>

                        <div class="flex gap-4 mt-4">
                            <button type="submit"
                                class="bg-[#0077B6] hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded-full shadow transition">
                                SIMPAN PERUBAHAN
                            </button>

                            <a href="{{ route('admin.products.index') }}"
                                class="bg-gray-200 text-gray-700 px-6 py-2 rounded-full hover:bg-gray-300 transition">
                                BATAL
                            </a>
                        </div>
                    </div>

                    <div class="flex flex-col items-center gap-4">
                        <label class="block text-sm font-semibold w-full text-left">Gambar Saat Ini</label>
                        <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}"
                            class="rounded-lg shadow-md w-64 h-64 object-cover border bg-white">
                        
                        <div class="w-full">
                            <label class="block text-sm font-semibold mb-1">Ganti Gambar (Opsional)</label>
                            <input type="file" name="gambar" class="w-full border rounded-md p-2 bg-white">
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection