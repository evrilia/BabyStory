@extends('layouts.admin')

@section('content')
    {{-- ================================================= --}}
    {{-- 1. LOAD CSS LIBRARY (LEAFLET + GEOCODER + SELECT2)--}}
    {{-- ================================================= --}}

    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    {{-- Leaflet Geocoder CSS (PENTING UNTUK SEARCH MAPS) --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        /* Fix tampilan Select2 agar mirip input Tailwind */
        .select2-container .select2-selection--single {
            height: 42px !important;
            border: 1px solid #d1d5db !important;
            border-radius: 0.5rem !important;
            display: flex;
            align-items: center;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
        }

        /* Pastikan Peta punya tinggi */
        #map {
            height: 350px;
            /* Saya perbesar sedikit */
            width: 100%;
            z-index: 1;
        }
    </style>

    <div class="flex min-h-screen bg-gray-50">
        <div class="flex-1 p-6">
            <div class="bg-[#B7E4FF] rounded-2xl shadow-md p-8 mt-6">
                <h2 class="text-2xl font-bold text-[#4B4B4B] mb-2">Tambah Pesanan</h2>
                <p class="text-sm text-gray-600 mb-6">Home > List Pesanan > Tambah Pesanan</p>

                <div class="bg-white rounded-2xl shadow-md p-8 mt-6">
                    <form action="{{ route('admin.orders.store') }}" method="POST" enctype="multipart/form-data"
                        id="orderForm">
                        @csrf

                        {{-- INPUT HIDDEN --}}
                        <input type="hidden" name="total" id="inputTotal" value="0">
                        <input type="hidden" name="latitude" id="lat">
                        <input type="hidden" name="longitude" id="lng">
                        <input type="hidden" name="biaya_pengiriman" id="inputOngkir" value="0">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div class="space-y-4">
                                <div>
                                    <label class="block font-semibold text-gray-700 mb-2">Nama Pelanggan</label>
                                    <input type="text" name="nama_pelanggan" required
                                        class="w-full border border-gray-300 rounded-lg p-2 focus:ring-pink-300">
                                </div>

                                <div>
                                    <label class="block font-semibold text-gray-700 mb-2">No HP</label>
                                    <input type="text" name="no_hp" pattern="[0-9]+" required
                                        class="w-full border border-gray-300 rounded-lg p-2 focus:ring-pink-300">
                                </div>

                                <div>
                                    <label class="block font-semibold text-gray-700 mb-2">Kota / Kecamatan</label>
                                    <input type="text" name="kota_tujuan" id="kotaInput"
                                        class="w-full border border-gray-300 rounded-lg p-2 bg-gray-100 cursor-not-allowed"
                                        placeholder="Terisi otomatis dari peta..." required readonly>
                                </div>

                                <div>
                                    <label class="block font-semibold text-gray-700 mb-2">Alamat Lengkap</label>
                                    <div class="flex gap-2">
                                        <textarea name="alamat" id="alamatInput" rows="2" required
                                            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-pink-300"
                                            placeholder="Ketik alamat manual..."></textarea>
                                        <button type="button" id="btnCariAlamat"
                                            class="bg-blue-500 text-white px-4 rounded-lg hover:bg-blue-600 text-sm font-semibold w-32">
                                            <i class="fas fa-search"></i> Cari
                                        </button>
                                    </div>
                                </div>

                                {{-- PETA LEAFLET --}}
                                <div>
                                    <label class="block font-semibold text-gray-700 mb-2">Titik Lokasi Pengiriman <span
                                            class="text-red-500">*</span></label>
                                    <div id="map" class="rounded-lg border border-gray-300"></div>
                                    <p class="text-xs text-blue-600 mt-1 font-semibold">
                                        *Gunakan tombol 🔍 di peta untuk mencari lokasi lebih akurat.
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block font-semibold text-gray-700 mb-2">Upload KTP</label>
                                    <input type="file" name="ktp" accept="image/*"
                                        class="w-full border border-gray-300 rounded-lg p-2 text-sm">
                                </div>

                                <div>
                                    <label class="block font-semibold text-gray-700 mb-2">Nama Produk</label>
                                    <select name="nama_produk" id="produkSelect"
                                        class="w-full border border-gray-300 rounded-lg p-2 focus:ring-pink-300" required>
                                        <option value="" data-price="0">-- Pilih Produk --</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->nama_produk }}" data-price="{{ $product->harga }}">
                                                {{ $product->nama_produk }} - ({{ $product->category->name ?? 'Umum' }}) | Stok:
                                                {{ $product->stok }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block font-semibold text-gray-700 mb-2">Tgl Mulai</label>
                                        <input type="date" name="start_date" id="startDate"
                                            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-pink-300"
                                            required>
                                    </div>
                                    <div>
                                        <label class="block font-semibold text-gray-700 mb-2">Tgl Selesai</label>
                                        <input type="date" name="end_date" id="endDate"
                                            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-pink-300"
                                            required>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 text-right">Durasi Sewa: <span id="durasiText"
                                        class="font-bold text-gray-800">0</span> Hari</p>

                                <div>
                                    <label class="block font-semibold text-gray-700 mb-2">Biaya Pengiriman
                                        (Otomatis)</label>
                                    <input type="text" id="displayOngkir"
                                        class="w-full border border-gray-300 rounded-lg p-2 bg-gray-100 font-bold text-gray-700"
                                        readonly value="Rp 0">
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 border-t pt-4 flex justify-end bg-gray-50 p-4 rounded-xl">
                            <div class="text-right space-y-1">
                                <p class="text-sm text-gray-600">Harga Sewa: <span id="displaySewa" class="font-semibold">Rp
                                        0</span></p>
                                <p class="text-sm text-gray-600">Ongkos Kirim: <span id="displayOngkirSummary"
                                        class="font-semibold">Rp 0</span></p>
                                <h3 class="text-3xl font-bold text-pink-500 mt-2">Total: <span id="displayTotal">Rp 0</span>
                                </h3>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-center gap-4">
                            <button type="submit"
                                class="bg-pink-400 text-white px-10 py-2 rounded-full hover:bg-pink-500 font-semibold shadow-md transition transform hover:scale-105">
                                Simpan Pesanan
                            </button>
                            <a href="{{ route('admin.orders.index') }}"
                                class="bg-gray-200 text-gray-700 px-10 py-2 rounded-full hover:bg-gray-300 font-semibold transition">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================= --}}
    {{-- 2. LOAD JS LIBRARY (WAJIB URUTANNYA) --}}
    {{-- ================================================= --}}

    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- Select2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    {{-- Leaflet Geocoder JS (PENTING! KEMARIN INI MUNGKIN HILANG) --}}
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // === SETUP PETA ===
            const tokoLat = -7.3837415;
            const tokoLng = 109.3650458;
            const map = L.map('map').setView([tokoLat, tokoLng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            L.marker([tokoLat, tokoLng]).addTo(map)
                .bindPopup("<b>Baby Story Toys</b><br>Wirasana").openPopup();

            let destinationMarker;
            let currentOngkir = 0;

            // === SETUP GEOCODER (PENCARIAN PETA) ===
            // Ini akan memunculkan tombol search di pojok kanan atas peta
            const geocoder = L.Control.geocoder({
                defaultMarkGeocode: false,
                placeholder: "Cari lokasi...",
                geocoder: L.Control.Geocoder.nominatim()
            })
                .on('markgeocode', function (e) {
                    const lat = e.geocode.center.lat;
                    const lng = e.geocode.center.lng;
                    updateMarkerAndPrice(lat, lng, e.geocode.name);
                    document.getElementById('alamatInput').value = e.geocode.name;
                })
                .addTo(map);

            // === LOGIKA MARHER & HARGA ===
            function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
                const R = 6371;
                const dLat = deg2rad(lat2 - lat1);
                const dLon = deg2rad(lon2 - lon1);
                const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * Math.sin(dLon / 2) * Math.sin(dLon / 2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                return R * c;
            }
            function deg2rad(deg) { return deg * (Math.PI / 180); }

            function updateMarkerAndPrice(lat, lng, addressName = null) {
                if (destinationMarker) destinationMarker.setLatLng([lat, lng]);
                else destinationMarker = L.marker([lat, lng]).addTo(map);

                map.flyTo([lat, lng], 16);
                document.getElementById('lat').value = lat;
                document.getElementById('lng').value = lng;

                const jarakKm = getDistanceFromLatLonInKm(tokoLat, tokoLng, lat, lng);
                if (jarakKm <= 5) currentOngkir = 0;
                else {
                    const sisaJarak = jarakKm - 5;
                    currentOngkir = Math.ceil(sisaJarak / 5) * 15000;
                }

                destinationMarker.bindPopup(`<b>Lokasi Terpilih</b><br>Jarak: ${jarakKm.toFixed(1)} km<br>Ongkir: Rp ${currentOngkir.toLocaleString('id-ID')}`).openPopup();
                calculate();

                if (!addressName) {
                    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
                        .then(res => res.json())
                        .then(data => {
                            const addr = data.address;
                            const kota = addr.city || addr.town || addr.village || addr.county || "Lokasi Terpilih";
                            document.getElementById('kotaInput').value = kota;
                            if (!document.getElementById('alamatInput').value) document.getElementById('alamatInput').value = data.display_name;
                        });
                } else {
                    document.getElementById('kotaInput').value = "Hasil Pencarian";
                }
            }

            map.on('click', function (e) { updateMarkerAndPrice(e.latlng.lat, e.latlng.lng); });

            // === TOMBOL CARI MANUAL (BACKUP) ===
            document.getElementById('btnCariAlamat').addEventListener('click', function () {
                const alamatText = document.getElementById('alamatInput').value;
                if (!alamatText) return alert("Isi alamat dulu!");

                // Tambahkan konteks pencarian agar lebih akurat
                const query = alamatText + ", Jawa Tengah, Indonesia";

                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.length > 0) updateMarkerAndPrice(parseFloat(data[0].lat), parseFloat(data[0].lon), data[0].display_name);
                        else alert("Lokasi tidak ditemukan. Coba gunakan fitur cari di dalam peta.");
                    });
            });

            // === SELECT2 & KALKULASI ===
            $('#produkSelect').select2({ placeholder: "-- Cari & Pilih Produk --", allowClear: true });
            $('#produkSelect').on('change', function () { calculate(); });

            const startDate = document.getElementById('startDate');
            const endDate = document.getElementById('endDate');

            function calculate() {
                const selectedOption = $('#produkSelect').find(':selected');
                const hargaHarian = parseInt(selectedOption.data('price') || 0);

                let durasi = 0;
                if (startDate.value && endDate.value) {
                    const start = new Date(startDate.value);
                    const end = new Date(endDate.value);
                    const diffTime = end - start;
                    if (diffTime >= 0) durasi = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                }

                const totalSewa = hargaHarian * durasi;
                const grandTotal = totalSewa + currentOngkir;

                document.getElementById('durasiText').textContent = durasi;

                const formatRupiah = (num) => 'Rp ' + num.toLocaleString('id-ID');
                document.getElementById('displayOngkir').value = formatRupiah(currentOngkir);
                document.getElementById('inputOngkir').value = currentOngkir;
                document.getElementById('displaySewa').textContent = formatRupiah(totalSewa);
                document.getElementById('displayOngkirSummary').textContent = formatRupiah(currentOngkir);
                document.getElementById('displayTotal').textContent = formatRupiah(grandTotal);
                document.getElementById('inputTotal').value = grandTotal;
            }

            startDate.addEventListener('change', calculate);
            endDate.addEventListener('change', calculate);
        });
    </script>
@endsection