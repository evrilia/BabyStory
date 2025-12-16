@extends('layouts.admin')

@section('content')
    {{-- 1. LOAD CSS LEAFLET --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <div class="flex min-h-screen bg-gray-50">
        <div class="flex-1 p-6">

            <div class="bg-[#B7E4FF] rounded-2xl shadow-md p-8 mt-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-[#4B4B4B]">Edit Pesanan
                            #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h2>
                        <p class="text-sm text-gray-600">Home > List Pesanan > Edit Pesanan</p>
                    </div>

                    {{-- Badge Status --}}
                    <span class="px-4 py-2 rounded-full font-bold text-sm
                                {{ $order->status == 'Selesai'
        ? 'bg-green-100 text-green-700'
        : ($order->status == 'Batal'
            ? 'bg-red-100 text-red-700'
            : ($order->status == 'Perpanjangan'
                ? 'bg-purple-100 text-purple-700'
                : 'bg-yellow-100 text-yellow-800')) }}">
                        {{ $order->status }}
                    </span>
                </div>

                <div class="bg-white rounded-2xl shadow-md p-8 mt-6">
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                            {{-- ========================== --}}
                            {{-- KOLOM KIRI (INFO & PETA) --}}
                            {{-- ========================== --}}
                            <div class="space-y-6">
                                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Info Pelanggan</h3>

                                <div>
                                    <label class="block font-semibold text-gray-600 text-sm mb-1">Nama Pelanggan</label>
                                    <input type="text" value="{{ $order->nama_pelanggan }}"
                                        class="w-full border border-gray-200 rounded-lg p-2 bg-gray-50 text-gray-500"
                                        readonly>
                                </div>

                                {{-- START PERBAIKAN: Tambah Email & Hapus Tombol Chat --}}
                                <div>
                                    <label class="block font-semibold text-gray-600 text-sm mb-1">Email</label>
                                    <input type="email" name="email" value="{{ $order->email ?? '' }}"
                                        class="w-full border border-gray-200 rounded-lg p-2 bg-gray-50 text-gray-500"
                                        readonly>
                                </div>

                                <div>
                                    <label class="block font-semibold text-gray-600 text-sm mb-1">No HP</label>
                                    <input type="text" value="{{ $order->no_hp }}"
                                        class="w-full border border-gray-200 rounded-lg p-2 bg-gray-50 text-gray-500"
                                        readonly>
                                    {{-- Tombol Chat dihilangkan --}}
                                </div>
                                {{-- END PERBAIKAN --}}

                                <div>
                                    <label class="block font-semibold text-gray-600 text-sm mb-1">Alamat Lengkap</label>
                                    <textarea rows="2"
                                        class="w-full border border-gray-200 rounded-lg p-2 bg-gray-50 text-gray-500"
                                        readonly>{{ $order->alamat }}</textarea>
                                </div>

                                <div>
                                    <label class="block font-semibold text-gray-600 text-sm mb-2">Lokasi Peta</label>
                                    @if ($order->latitude && $order->longitude)
                                        <div id="map" class="w-full h-56 rounded-lg border border-gray-300 z-0">
                                        </div>
                                        <a href="http://googleusercontent.com/maps.google.com/?q={{ $order->latitude }},{{ $order->longitude }}"
                                            target="_blank" class="text-blue-500 text-xs mt-1 hover:underline inline-block">
                                            <i class="fas fa-map-marker-alt"></i> Buka di Google Maps
                                        </a>
                                    @else
                                        <div
                                            class="w-full h-24 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 text-sm italic border border-dashed border-gray-300">
                                            Tidak ada data koordinat peta.
                                        </div>
                                    @endif
                                </div>
                            </div>


                            {{-- ========================== --}}
                            {{-- KOLOM KANAN (SEWA & BIAYA) --}}
                            {{-- ========================== --}}
                            <div class="space-y-6">
                                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Detail Sewa & Tagihan</h3>

                                {{-- Produk & Harga Harian (Hidden) --}}
                                <div>
                                    <label class="block font-semibold text-gray-600 text-sm mb-1">Produk Disewa</label>
                                    <input type="text" value="{{ $order->nama_produk }}"
                                        class="w-full border border-gray-200 rounded-lg p-2 bg-gray-50 text-gray-500"
                                        readonly>

                                    @php
                                        $productData = \App\Models\Product::where('nama_produk', $order->nama_produk)->first();
                                        $hargaPerHari = $productData ? $productData->harga : 0;
                                    @endphp
                                    <input type="hidden" id="hargaPerHari" value="{{ $hargaPerHari }}">
                                </div>

                                {{-- Tanggal Sewa --}}
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block font-semibold text-gray-600 text-sm mb-1">Mulai Sewa</label>
                                        <input type="date" id="startDate" name="start_date"
                                            value="{{ \Carbon\Carbon::parse($order->start_date)->format('Y-m-d') }}"
                                            class="w-full border border-gray-200 rounded-lg p-2 bg-gray-50 text-gray-500"
                                            readonly>
                                    </div>
                                    <div>
                                        <label class="block font-bold text-blue-600 text-sm mb-1">Selesai Sewa
                                            (Edit)</label>
                                        <input type="date" id="endDate" name="end_date"
                                            value="{{ \Carbon\Carbon::parse($order->end_date)->format('Y-m-d') }}"
                                            class="w-full border-2 border-blue-200 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 font-semibold text-gray-800 bg-white">
                                    </div>
                                </div>

                                <div>
                                    <label class="block font-semibold text-gray-600 text-sm mb-1">Durasi</label>
                                    <input type="text" id="durasiText" name="lama_sewa" value="{{ $order->lama_sewa }}"
                                        class="w-full border border-gray-200 rounded-lg p-2 bg-gray-50 text-gray-500"
                                        readonly>
                                </div>

                                {{-- RINCIAN BIAYA LENGKAP --}}
                                <div>
                                    <label class="block font-semibold text-gray-600 text-sm mb-1">Rincian Biaya</label>
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 text-sm space-y-2">

                                        {{-- 1. Total Sewa Produk (Hitung Manual PHP Awal) --}}
                                        <div class="flex justify-between text-gray-600">
                                            <span>Total Sewa Produk</span>
                                            <span>Rp <span
                                                    id="displayTotalProduk">{{ number_format($order->total - $order->biaya_pengiriman, 0, ',', '.') }}</span></span>
                                        </div>

                                        {{-- 2. Biaya Kirim (Tetap) --}}
                                        <div class="flex justify-between text-gray-600">
                                            <span>Biaya Kirim</span>
                                            <span>Rp <span
                                                    id="displayOngkir">{{ number_format($order->biaya_pengiriman, 0, ',', '.') }}</span></span>
                                        </div>
                                        <input type="hidden" id="valOngkir" value="{{ $order->biaya_pengiriman }}">

                                        <hr class="border-gray-300 my-1">

                                        {{-- 3. Total Baru --}}
                                        <div class="flex justify-between text-gray-800 font-semibold">
                                            <span>Total Baru</span>
                                            <span>Rp <span
                                                    id="displayTotalBaru">{{ number_format($order->total, 0, ',', '.') }}</span></span>
                                        </div>

                                        {{-- 4. Sudah Dibayar --}}
                                        <div class="flex justify-between text-green-600">
                                            <span>Sudah Dibayar</span>
                                            <span>- Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                                        </div>
                                        {{-- Simpan nilai asli dari DB (tanpa format) --}}
                                        <input type="hidden" id="totalSudahDibayar" value="{{ $order->total }}">

                                        <hr class="border-gray-300 my-1">

                                        {{-- 5. Tagihan Tambahan --}}
                                        <div class="flex justify-between items-center pt-1">
                                            <span class="font-bold text-gray-800 text-lg">Tagihan Tambahan</span>
                                            <span class="font-bold text-pink-600 text-2xl" id="displayTagihanTambahan">Rp
                                                0</span>
                                        </div>

                                        {{-- Input Hidden Total (Wajib untuk update DB) --}}
                                        <input type="hidden" id="inputTotal" name="total" value="{{ $order->total }}">

                                        <p class="text-xs text-gray-400 italic mt-2 text-right">*Tagihan muncul otomatis
                                            jika durasi ditambah.</p>
                                    </div>
                                </div>

                                {{-- Update Status --}}
                                <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 shadow-sm">
                                    <label class="block font-bold text-gray-800 mb-2">Update Status Pesanan</label>
                                    <select name="status" id="statusSelect"
                                        class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-300 cursor-pointer">
                                        <option value="Konfirmasi" {{ $order->status == 'Konfirmasi' ? 'selected' : '' }}>
                                            Konfirmasi</option>
                                        <option value="Proses" {{ $order->status == 'Proses' ? 'selected' : '' }}>Proses
                                        </option>
                                        <option value="Perpanjangan" {{ $order->status == 'Perpanjangan' ? 'selected' : '' }}>
                                            Perpanjangan</option>
                                        <option value="Selesai" {{ $order->status == 'Selesai' ? 'selected' : '' }}>Selesai
                                        </option>
                                        <option value="Batal" {{ $order->status == 'Batal' ? 'selected' : '' }}>Batal</option>
                                    </select>
                                </div>

                                {{-- Foto KTP --}}
                                <div>
                                    <label class="block font-semibold text-gray-600 text-sm mb-1">Foto KTP</label>
                                    @if ($order->ktp)
                                        <a href="{{ asset('storage/' . $order->ktp) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $order->ktp) }}" alt="KTP"
                                                class="h-24 object-cover rounded-lg border hover:opacity-80 transition">
                                        </a>
                                    @else
                                        <span class="text-sm text-gray-400 italic">Tidak ada foto.</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="mt-8 border-t pt-6 flex justify-end gap-4">
                            <a href="{{ route('admin.orders.index') }}"
                                class="px-6 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 font-semibold transition">
                                Kembali
                            </a>
                            <button type="submit"
                                class="px-8 py-2 rounded-lg bg-[#0077B6] text-white hover:bg-[#005A8D] font-bold shadow-md transition transform hover:scale-105">
                                Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. LOAD JAVASCRIPT --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // === A. PETA ===
            const lat = {{ $order->latitude ?? 0 }};
            const lng = {{ $order->longitude ?? 0 }};

            if (lat != 0 && lng != 0) {
                const map = L.map('map').setView([lat, lng], 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '© OpenStreetMap' }).addTo(map);
                L.marker([lat, lng]).addTo(map).bindPopup("<b>Lokasi Pengiriman</b><br>{{ $order->alamat }}").openPopup();
            }

            // === B. LOGIKA HITUNG ULANG (PERPANJANGAN) ===
            const startDateEl = document.getElementById('startDate');
            const endDateEl = document.getElementById('endDate');
            const durasiText = document.getElementById('durasiText');
            const inputTotal = document.getElementById('inputTotal');
            const statusSelect = document.getElementById('statusSelect');

            // Elemen Tampilan Angka
            const displayTotalProduk = document.getElementById('displayTotalProduk');
            const displayTotalBaru = document.getElementById('displayTotalBaru');
            const displayTagihanTambahan = document.getElementById('displayTagihanTambahan');

            // Data Awal (Parse Int agar terbaca sebagai angka, bukan string)
            const hargaPerHari = parseInt(document.getElementById('hargaPerHari').value || 0);
            const ongkir = parseInt(document.getElementById('valOngkir').value || 0);
            const totalSudahDibayar = parseInt(document.getElementById('totalSudahDibayar').value || 0);
            const originalEndDate = endDateEl.value;

            // Helper Format Rupiah
            const formatIDR = (num) => num.toLocaleString('id-ID');

            function recalculate() {
                // Validasi agar tidak error jika input kosong
                if (!startDateEl.value || !endDateEl.value) return;

                // Mengatasi masalah perhitungan hari (seperti yang didiskusikan sebelumnya)
                const start = new Date(startDateEl.value);
                const end = new Date(endDateEl.value);

                // Normalisasi waktu ke tengah malam (00:00:00)
                start.setHours(0, 0, 0, 0);
                end.setHours(0, 0, 0, 0);

                const diffTime = end.getTime() - start.getTime();

                if (diffTime >= 0) {
                    const diffDays = Math.round(diffTime / (1000 * 60 * 60 * 24)) + 1;
                    durasiText.value = diffDays + " Hari";

                    const totalProdukOnly = diffDays * hargaPerHari;

                    const totalBaru = totalProdukOnly + ongkir;

                    let tagihanTambahan = totalBaru - totalSudahDibayar;
                    if (tagihanTambahan < 0) tagihanTambahan = 0; // Pastikan tagihan tidak negatif

                    if (displayTotalProduk) displayTotalProduk.innerText = formatIDR(totalProdukOnly);
                    if (displayTotalBaru) displayTotalBaru.innerText = formatIDR(totalBaru);
                    if (displayTagihanTambahan) displayTagihanTambahan.innerText = 'Rp ' + formatIDR(tagihanTambahan);

                    inputTotal.value = totalBaru;

                    if (endDateEl.value > originalEndDate) {
                        statusSelect.value = 'Perpanjangan';
                    }
                } else {
                    alert("Tanggal selesai tidak boleh mundur dari tanggal mulai!");
                    endDateEl.value = originalEndDate;
                    recalculate();
                }
            }

            endDateEl.addEventListener('change', recalculate);

            recalculate();
        });
    </script>
@endsection