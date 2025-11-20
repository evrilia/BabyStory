@extends('layouts.admin')

@section('content')
    <div class="flex min-h-screen bg-gray-50">
        <div class="flex-1 p-6">
            <div class="bg-[#B7E4FF] rounded-2xl shadow-md p-6 mt-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">Edit Kategori</h2>
                <p class="text-sm text-gray-600 mb-6">
                    <span class="text-blue-700 font-medium">Home</span> ›
                    <span class="text-blue-700 font-medium">Kategori</span> ›
                    <span class="text-gray-800">Edit Kategori</span>
                </p>

                {{-- Tampilkan Error Validasi jika ada --}}
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <strong class="font-bold">Ada Kesalahan!</strong>
                        <ul class="mt-1 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST"
                    enctype="multipart/form-data"
                    class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-white rounded-2xl p-8 shadow-sm">
                    @csrf
                    @method('PUT') {{-- Wajib untuk Update --}}

                    <div class="flex flex-col space-y-6">

                        {{-- Nama Kategori --}}
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Nama Kategori</label>
                            <input type="text" name="name" value="{{ old('name', $category->name) }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none transition"
                                placeholder="Contoh: Stroller" required>
                        </div>

                        {{-- Deskripsi Kategori --}}
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Deskripsi Kategori</label>
                            <textarea name="description" rows="8"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none transition resize-none"
                                placeholder="Tuliskan deskripsi...">{{ old('description', $category->description) }}</textarea>
                        </div>
                    </div>

                    <div class="flex flex-col">
                        <label class="block text-gray-700 font-bold mb-2">Gambar Sampul</label>
                        <div
                            class="flex-1 flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-gray-50 transition cursor-pointer relative group">

                            <img id="imagePreview"
                                src="{{ $category->image ? asset('storage/' . $category->image) : asset('images/ph_image-light.png') }}"
                                alt="Preview"
                                class="w-48 h-48 mb-3 object-contain opacity-90 transition-opacity group-hover:opacity-100">

                            <p class="text-gray-500 font-medium">Klik untuk ganti gambar</p>
                            <p class="text-xs text-gray-400 mt-1">Format: JPEG, PNG (Max 2MB)</p>

                            <input id="imageInput" type="file" name="image" accept=".jpg,.jpeg,.png,image/*"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        </div>
                    </div>

                    <div class="md:col-span-2 flex items-center justify-end gap-4 mt-8 pt-6 border-t border-gray-100">

                        {{-- Tombol Cancel (Abu-abu) --}}
                        <a href="{{ route('admin.categories.index') }}"
                            class="relative z-10 bg-gray-200 text-gray-700 px-6 py-2 rounded-full hover:bg-gray-300 transition">
                            CANCEL
                        </a>

                        {{-- Tombol Delete (Pink - Sesuai Detail Produk) --}}
                        <button type="button"
                            onclick="if(confirm('Yakin hapus kategori ini?')) document.getElementById('delete-form-{{ $category->id }}').submit();"
                            class="bg-pink-300 hover:bg-pink-500 text-white font-semibold px-6 py-2 rounded-full shadow transition duration-300 ease-in-out">
                            DELETE
                        </button>

                        {{-- Tombol Update (Biru Muda - Sesuai Detail Produk) --}}
                        <button type="submit"
                            class="bg-[#8fd4ff] hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded-full shadow transition duration-300 ease-in-out">
                            UPDATE
                        </button>
                    </div>
                </form>

                {{-- Form Hidden untuk Delete --}}
                <form id="delete-form-{{ $category->id }}" action="{{ route('admin.categories.destroy', $category->id) }}"
                    method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('imageInput');
            const preview = document.getElementById('imagePreview');

            if (!input || !preview) return;

            input.addEventListener('change', function (e) {
                const file = e.target.files && e.target.files[0];
                if (file) {
                    preview.src = URL.createObjectURL(file);
                }
            });
        });
    </script>
@endsection