@extends('layouts.admin')

@section('content')
    <div class="flex min-h-screen bg-gray-50">

        <!-- Konten utama -->
        <div class="flex-1 p-6">

            <div class="bg-[#B7E4FF] rounded-2xl shadow-md p-6 mt-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Kategori</h2>
                        <p class="text-sm text-gray-600">Home > Kategori</p>
                    </div>
                    <a href="{{ route('admin.categories.create') }}"
                        class="bg-pink-400 text-white px-4 py-2 rounded-full hover:bg-pink-500 transition">
                        + Tambah Kategori
                    </a>
                </div>

                <!-- Grid Kategori -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    @forelse ($categories as $category)
                        <!-- Card Kategori -->
                        <a href="{{ route('admin.categories.edit', $category->id) }}"
                            class="flex items-center bg-white rounded-xl shadow p-4 hover:shadow-lg transition duration-200">
                            <div class="w-20 h-20 bg-gray-200 rounded-xl overflow-hidden flex items-center justify-center">
                                @if ($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                        class="object-cover w-full h-full">
                                @else
                                    <span class="text-gray-400 text-sm">No Image</span>
                                @endif
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold text-gray-700">{{ $category->name }}</h3>
                                <p class="text-gray-500 text-sm">Jumlah Produk: {{ $category->product_count ?? 0 }}</p>
                            </div>
                        </a>
                    @empty
                        <p class="text-gray-600">Belum ada kategori.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
