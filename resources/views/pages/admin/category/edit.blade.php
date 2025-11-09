@extends('layouts.admin')

@section('content')
    <div class="p-6">
        <h2 class="text-xl font-semibold mb-4 text-[#0077B6]">Edit Kategori</h2>
        <p class="text-sm text-gray-500 mb-6">Home > Kategori > Edit Kategori</p>

        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white rounded-2xl p-6 shadow-sm">
                <!-- KIRI -->
                <div class="flex flex-col space-y-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Nama Kategori</label>
                        <input type="text" name="name" value="{{ old('name', $category->name) }}"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-[#0077B6] focus:outline-none"
                            placeholder="Masukkan nama kategori" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Deskripsi Kategori</label>
                        <textarea name="description" rows="3"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-[#0077B6] focus:outline-none"
                            placeholder="Masukkan deskripsi kategori">{{ old('description', $category->description) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Status</label>
                        <input type="text" name="status" value="{{ old('status', $category->status) }}"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-[#0077B6] focus:outline-none"
                            placeholder="Aktif / Nonaktif" required>
                    </div>
                </div>

                <!-- KANAN -->
                <div
                    class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                    <!-- Preview Gambar -->
                    <img id="imagePreview"
                        src="{{ $category->image ? asset('storage/' . $category->image) : asset('images/ph_image-light.png') }}"
                        alt="Preview" class="w-40 h-40 mb-3 object-contain opacity-90 rounded-md">
                    <p class="text-gray-500 mb-2">Upload gambar kategori (JPEG / PNG)</p>
                    <input id="imageInput" type="file" name="image" accept=".jpg,.jpeg,.png,image/*"
                        class="mt-2 text-sm text-gray-600 cursor-pointer">
                </div>

                <!-- TOMBOL -->
                <div class="md:col-span-2 flex justify-center space-x-4 mt-4">
                    <!-- Update -->
                    <button type="submit"
                        class="bg-[#0077B6] hover:bg-[#005A8D] text-white font-semibold px-6 py-2 rounded-md transition">
                        UPDATE
                    </button>

                    <!-- Delete -->
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-2 rounded-md transition">
                            DELETE
                        </button>
                    </form>

                    <!-- Cancel -->
                    <a href="{{ route('admin.categories.index') }}"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-6 py-2 rounded-md transition">
                        CANCEL
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Preview Gambar -->
    <script>
        const input = document.getElementById('imageInput');
        const preview = document.getElementById('imagePreview');
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) preview.src = URL.createObjectURL(file);
        });
    </script>
@endsection
