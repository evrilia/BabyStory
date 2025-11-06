@extends('layouts.admin')

@section('content')
    <div class="flex min-h-screen bg-gray-50">

        <!-- Konten utama -->
        <div class="flex-1 p-6">

            <div class="bg-[#B7E4FF] rounded-2xl shadow-md p-6 mt-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">Tambah Kategori</h2>
                <p class="text-sm text-gray-600 mb-6">
                    <span class="text-blue-700 font-medium">Home</span> ›
                    <span class="text-blue-700 font-medium">Kategori</span> ›
                    <span class="text-gray-800">Tambah Kategori</span>
                </p>

                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data"
                    class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white rounded-2xl p-6 shadow-sm">
                    @csrf

                    <!-- Kiri -->
                    <div class="flex flex-col space-y-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Nama Kategori</label>
                            <input type="text" name="name"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none"
                                placeholder="Ketik disini..." required>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Deskripsi Kategori</label>
                            <textarea name="description" rows="3"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none"
                                placeholder="Ketik disini..."></textarea>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Status</label>
                            <input type="text" name="status"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none"
                                placeholder="Aktif / Nonaktif" required>
                        </div>
                    </div>

                    <!-- Kanan -->
                    <div
                        class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                        <!-- Preview image (starts with placeholder) -->
                        <img id="imagePreview" src="{{ asset('images/ph_image-light.png') }}" alt="Preview"
                            class="w-40 h-40 mb-3 object-contain opacity-90 rounded-md">
                        <p class="text-gray-500 mb-2">Drop your image here, JPEG and PNG are allowed</p>
                        <input id="imageInput" type="file" name="image" accept=".jpg,.jpeg,.png,image/*"
                            class="mt-2 text-sm text-gray-600 cursor-pointer">
                    </div>


                    <!-- Tombol -->
                    <div class="md:col-span-2 flex justify-center space-x-4 mt-4">
                        <button type="submit"
                            class="bg-pink-400 text-white font-semibold px-6 py-2 rounded-md hover:bg-pink-500 transition">SIMPAN</button>
                        <a href="{{ route('admin.categories.index') }}"
                            class="border border-gray-400 text-gray-700 font-semibold px-6 py-2 rounded-md hover:bg-gray-100 transition">BATAL</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('imageInput');
            const preview = document.getElementById('imagePreview');
            const placeholderUrl = "{{ asset('images/ph_image-light.png') }}";
            if (!input || !preview) return;

            input.addEventListener('change', function(e) {
                const file = e.target.files && e.target.files[0];
                if (!file) {
                    preview.src = placeholderUrl;
                    return;
                }
                if (!file.type.match('image.*')) {
                    // Not an image - reset to placeholder
                    preview.src = placeholderUrl;
                    return;
                }

                // Show selected image
                const url = URL.createObjectURL(file);
                preview.src = url;

                // Optional: revoke object URL after image loads to free memory
                preview.onload = function() {
                    try {
                        URL.revokeObjectURL(url);
                    } catch (err) {
                        /* ignore */ }
                };
            });
        });
    </script>
@endsection
