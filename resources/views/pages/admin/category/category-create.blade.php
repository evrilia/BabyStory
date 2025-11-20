@extends('layouts.admin')

@section('content')
    <div class="flex min-h-screen bg-gray-50">

        <div class="flex-1 p-6">

            <div class="bg-[#B7E4FF] rounded-2xl shadow-md p-6 mt-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">Tambah Kategori</h2>
                <p class="text-sm text-gray-600 mb-6">
                    <span class="text-blue-700 font-medium">Home</span> ›
                    <span class="text-blue-700 font-medium">Kategori</span> ›
                    <span class="text-gray-800">Tambah Kategori</span>
                </p>

                {{-- Cek Error Validasi --}}
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <strong class="font-bold">Gagal Menyimpan!</strong>
                        <ul class="mt-1 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data"
                    class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-white rounded-2xl p-8 shadow-sm">
                    @csrf

                    <div class="flex flex-col space-y-6">

                        {{-- Nama Kategori --}}
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Nama Kategori</label>
                            <input type="text" name="name"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none transition"
                                placeholder="Contoh: Stroller, Pakaian, Mainan..." required>
                        </div>

                        {{-- Deskripsi Kategori (Dibuat lebih tinggi agar seimbang dengan gambar) --}}
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Deskripsi Kategori</label>
                            <textarea name="description" rows="8"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none transition resize-none"
                                placeholder="Tuliskan deskripsi singkat mengenai kategori ini..."></textarea>
                        </div>
                    </div>

                    <div class="flex flex-col">
                        <label class="block text-gray-700 font-bold mb-2">Gambar Sampul</label>
                        <div
                            class="flex-1 flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-gray-50 transition cursor-pointer relative group">

                            <img id="imagePreview" src="{{ asset('images/ph_image-light.png') }}" alt="Preview"
                                class="w-48 h-48 mb-3 object-contain opacity-80 transition-opacity group-hover:opacity-100">

                            <p class="text-gray-500 font-medium">Klik untuk upload gambar</p>
                            <p class="text-xs text-gray-400 mt-1">Format: JPEG, PNG (Max 2MB)</p>

                            <input id="imageInput" type="file" name="image" accept=".jpg,.jpeg,.png,image/*"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        </div>
                    </div>

                    <div class="md:col-span-2 flex justify-end space-x-4 mt-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.categories.index') }}"
                            class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-semibold hover:bg-gray-100 transition">
                            BATAL
                        </a>
                        <button type="submit"
                            class="px-8 py-2.5 rounded-lg bg-pink-400 text-white font-bold hover:bg-pink-500 shadow-md transition transform hover:scale-105">
                            SIMPAN
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script Preview Gambar --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('imageInput');
            const preview = document.getElementById('imagePreview');
            // Ganti path ini sesuai gambar placeholder Anda
            const placeholderUrl = "{{ asset('images/ph_image-light.png') }}";

            if (!input || !preview) return;

            input.addEventListener('change', function (e) {
                const file = e.target.files && e.target.files[0];
                if (!file) {
                    preview.src = placeholderUrl;
                    return;
                }
                if (!file.type.match('image.*')) {
                    alert("Mohon upload file gambar (JPG/PNG)!");
                    return;
                }

                const url = URL.createObjectURL(file);
                preview.src = url;

                preview.onload = function () {
                    URL.revokeObjectURL(url);
                };
            });
        });
    </script>
@endsection