@extends('layouts.admin')

@section('content')
    <div class="flex min-h-screen bg-gray-50">
        <div class="flex-1 p-6">
            <div class="bg-[#B7E4FF] rounded-2xl shadow-md p-8 mt-6">
                <h2 class="text-2xl font-bold text-[#4B4B4B] mb-2">Tambah Pesanan</h2>
                <p class="text-sm text-gray-600 mb-6">Home > List Pesanan > Tambah Pesanan</p>

                <div class="bg-white rounded-2xl shadow-md p-8 mt-6">
                    <form action="{{ route('admin.orders.store') }}" method="POST" enctype="multipart/form-data"
                        id="orderForm">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Pelanggan -->
                            <div>
                                <label class="block font-semibold text-gray-700 mb-2">Nama Pelanggan</label>
                                <input type="text" name="nama_pelanggan" required
                                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-pink-200">
                            </div>

                            <!-- No HP -->
                            <div>
                                <label class="block font-semibold text-gray-700 mb-2">No HP</label>
                                <input type="text" name="no_hp" maxlength="13" minlength="12" required
                                    pattern="^[0-9]{12,13}$" title="Nomor HP hanya boleh berisi angka (12–13 digit)"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-pink-200">
                            </div>

                            <!-- Alamat -->
                            <div class="md:col-span-1">
                                <label class="block font-semibold text-gray-700 mb-2">Alamat</label>
                                <textarea name="alamat" rows="3" required
                                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-pink-200"></textarea>
                            </div>

                            <!-- Upload KTP -->
                            <div>
                                <label class="block font-semibold text-gray-700 mb-2">Upload KTP</label>
                                <input type="file" name="ktp" accept="image/*"
                                    class="w-full border border-gray-300 rounded-lg p-2 text-sm">
                                <p class="text-xs text-gray-500 mt-1">*Ukuran maksimal 3MB</p>
                            </div>

                            <!-- Nama Produk -->
                            <div>
                                <label class="block font-semibold text-gray-700 mb-2">Nama Produk</label>
                                <select name="nama_produk" id="produkSelect"
                                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-pink-200">
                                    <option value="" data-price="0">Pilih Produk</option>
                                    <option value="Stroller" data-price="100000">Stroller (Rp 100.000)</option>
                                    <option value="Box Bayi" data-price="150000">Box Bayi (Rp 150.000)</option>
                                    <option value="Car Seat" data-price="120000">Car Seat (Rp 120.000)</option>
                                </select>
                            </div>

                            <!-- Lama Sewa -->
                            <div>
                                <label class="block font-semibold text-gray-700 mb-2">Lama Sewa</label>
                                <select name="lama_sewa" id="lamaSewa"
                                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-pink-200">
                                    <option value="1" data-multiplier="1">1 Minggu</option>
                                    <option value="2" data-multiplier="2">2 Minggu</option>
                                    <option value="4" data-multiplier="4">1 Bulan</option>
                                </select>
                            </div>

                            <!-- Biaya Pengiriman -->
                            <div>
                                <label class="block font-semibold text-gray-700 mb-2">Biaya Pengiriman</label>
                                <select name="biaya_pengiriman" id="biayaKirim"
                                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-pink-200">
                                    <option value="0">Rp 0</option>
                                    <option value="10000">Rp 10.000</option>
                                    <option value="20000">Rp 20.000</option>
                                </select>
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block font-semibold text-gray-700 mb-2">Status Saat Ini</label>
                                <select name="status"
                                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-pink-200">
                                    <option value="Dipesan">Dipesan</option>
                                    <option value="Konfirmasi">Konfirmasi</option>
                                    <option value="Selesai">Selesai</option>
                                    <option value="Batal">Batal</option>
                                </select>
                            </div>
                        </div>

                        <!-- Bagian Total -->
                        <div class="mt-6 flex justify-end">
                            <div class="text-right">
                                <p class="text-sm">Subtotal: <span id="subtotal" class="font-semibold">Rp 0</span></p>
                                <p class="text-sm">Pengiriman: <span id="kirim" class="font-semibold">Rp 0</span></p>
                                <p class="text-lg font-bold mt-2">Total: <span id="total" class="text-pink-500">Rp
                                        0</span></p>
                            </div>
                        </div>

                        <!-- Tombol -->
                        <div class="mt-8 flex flex-wrap justify-center items-center gap-4 text-center">
                            <button type="submit"
                                class="bg-pink-400 text-white px-10 py-2 rounded-full hover:bg-pink-500 transition w-full sm:w-auto">
                                Simpan
                            </button>
                            <a href="{{ route('admin.orders.index') }}"
                                class="bg-gray-200 text-gray-700 px-10 py-2 rounded-full hover:bg-gray-300 transition w-full sm:w-auto">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const produkSelect = document.getElementById('produkSelect');
        const lamaSewa = document.getElementById('lamaSewa');
        const biayaKirim = document.getElementById('biayaKirim');
        const subtotalEl = document.getElementById('subtotal');
        const kirimEl = document.getElementById('kirim');
        const totalEl = document.getElementById('total');

        function updateTotal() {
            const hargaProduk = parseInt(produkSelect.selectedOptions[0].dataset.price || 0);
            const lama = parseInt(lamaSewa.selectedOptions[0].dataset.multiplier || 1);
            const ongkir = parseInt(biayaKirim.value || 0);

            const subtotal = hargaProduk * lama;
            const total = subtotal + ongkir;

            subtotalEl.textContent = 'Rp ' + subtotal.toLocaleString();
            kirimEl.textContent = 'Rp ' + ongkir.toLocaleString();
            totalEl.textContent = 'Rp ' + total.toLocaleString();
        }

        produkSelect.addEventListener('change', updateTotal);
        lamaSewa.addEventListener('change', updateTotal);
        biayaKirim.addEventListener('change', updateTotal);
    </script>
@endsection
