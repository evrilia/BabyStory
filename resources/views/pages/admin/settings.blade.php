@extends('layouts.admin')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    <div class="flex-1 p-6">
        <div class="bg-[#B7E4FF] rounded-2xl shadow-md p-6 mt-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Pengaturan Notifikasi Email</h2>
            <p class="text-sm text-gray-600 mb-6">Home > Settings > Email Reminder</p>

            {{-- Pesan Sukses --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.settings.update') }}" method="POST" class="bg-white rounded-2xl p-8 shadow-sm">
                @csrf
                
                {{-- BAGIAN 1: Konfigurasi Header Email --}}
                <div class="mb-8 border-b pb-6">
                    <h3 class="text-lg font-bold text-gray-700 mb-4 border-l-4 border-pink-400 pl-3">Konfigurasi Email</h3>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Judul Email (Subject)</label>
                            <input type="text" name="email_subject" value="{{ $settings['email_subject'] ?? 'Peringatan Masa Sewa - Baby Story' }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-300 outline-none"
                                placeholder="Contoh: Reminder Penyewaan - Baby Story">
                            <p class="text-xs text-gray-400 mt-1">Judul ini yang akan muncul pertama kali di notifikasi HP pelanggan.</p>
                        </div>
                    </div>
                </div>

                {{-- BAGIAN 2: Template Isi Pesan --}}
                <div>
                    <h3 class="text-lg font-bold text-gray-700 mb-4 border-l-4 border-blue-400 pl-3">Template Isi Email Otomatis</h3>
                    
                    {{-- Petunjuk Variabel --}}
                    <div class="bg-blue-50 p-4 rounded-lg mb-4 text-sm text-blue-800 border border-blue-100">
                        <strong class="block mb-1"><i class="fas fa-info-circle"></i> Variabel Dinamis:</strong>
                        Gunakan kode berikut di dalam pesan, sistem akan menggantinya otomatis:
                        <ul class="list-disc list-inside mt-1 ml-2">
                            <li><code>{nama}</code> : Nama Pelanggan</li>
                            <li><code>{produk}</code> : Nama Produk yang disewa</li>
                            <li><code>{tanggal}</code> : Tanggal Berakhir Sewa</li>
                        </ul>
                    </div>

                    <div class="space-y-6">
                        {{-- H-3 --}}
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Isi Pesan H-3 (3 Hari Sebelum Berakhir)</label>
                            <textarea name="msg_h3" rows="5" 
                                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-pink-300 outline-none resize-y"
                                placeholder="Tulis pesan pengingat H-3 di sini...">{{ $settings['msg_h3'] ?? '' }}</textarea>
                        </div>

                        {{-- H-2 --}}
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Isi Pesan H-2 (2 Hari Sebelum Berakhir)</label>
                            <textarea name="msg_h2" rows="5" 
                                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-pink-300 outline-none resize-y"
                                placeholder="Tulis pesan pengingat H-2 di sini...">{{ $settings['msg_h2'] ?? '' }}</textarea>
                        </div>

                        {{-- H-1 --}}
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Isi Pesan H-1 (Besok Berakhir)</label>
                            <textarea name="msg_h1" rows="5" 
                                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-pink-300 outline-none resize-y"
                                placeholder="Tulis pesan pengingat H-1 di sini...">{{ $settings['msg_h1'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Tombol Simpan --}}
                <div class="mt-8 flex justify-end pt-6 border-t">
                    <button type="submit" class="bg-pink-400 hover:bg-pink-500 text-white font-bold py-3 px-8 rounded-full shadow transition transform hover:scale-105">
                        SIMPAN PENGATURAN
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection