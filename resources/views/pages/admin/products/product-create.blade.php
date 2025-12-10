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

                        {{-- Tampilkan Error Global jika ada --}}
                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                                <strong>Gagal menyimpan!</strong> Harap periksa kembali input Anda.
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                                <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" class="w-full border rounded-md p-2" required>
                                @error('nama_produk') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                                <label class="block text-sm font-medium text-gray-700 mt-4 mb-1">Deskripsi</label>
                                <textarea name="deskripsi" rows="4" class="w-full border rounded-md p-2">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror


                                <div class="grid grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                                        <select name="category_id" class="w-full border rounded-md p-2" required>
                                            <option value="">Pilih Kategori</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                                        <input type="number" name="stok" value="{{ old('stok') }}" class="w-full border rounded-md p-2" required>
                                        @error('stok') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <label class="block text-sm font-medium text-gray-700 mt-4 mb-1">Brand</label>
                                <input type="text" name="brand" value="{{ old('brand') }}" class="w-full border rounded-md p-2">
                                @error('brand') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror


                                <div class="mb-4 mt-4">
                                    <label class="block text-gray-700 font-bold mb-2">Harga Sewa</label>
                                    <input type="number" name="harga" value="{{ old('harga') }}" class="w-full border rounded-md p-2" required>
                                    @error('harga') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            {{-- KOTAK UPLOAD GAMBAR --}}
                            <div class="flex justify-center items-center border-2 border-dashed border-gray-300 rounded-md p-6 relative group">
                                <div class="text-center">
                                    <img id="image-preview" src="{{ asset('images/ph_image-light.png') }}" class="w-24 opacity-70 mx-auto transition-opacity group-hover:opacity-100">
                                    
                                    <p class="text-sm text-gray-500 mb-2 mt-2">Upload gambar (JPEG/PNG)</p>
                                    
                                    <input type="file" name="gambar" id="image-input" class="block w-full text-sm text-gray-700 mx-auto">
                                    @error('gambar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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

    {{-- SCRIPT PREVIEW GAMBAR --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image-input');
            const imagePreview = document.getElementById('image-preview');

            if (imageInput && imagePreview) {
                imageInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            imagePreview.src = e.target.result;
                            imagePreview.classList.remove('opacity-70', 'w-24'); 
                            imagePreview.classList.add('h-40', 'w-auto', 'object-contain', 'rounded-md');
                        }
                        
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
@endsection