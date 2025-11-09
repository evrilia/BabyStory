<div class="grid grid-cols-4 gap-4 mt-4">
    <div class="bg-white p-4 rounded-xl shadow">
        <p class="text-sm text-gray-500">Total Users</p>
        <h3 class="text-xl font-semibold">{{ $totalUsers }} Users</h3>
    </div>
    <div class="bg-white p-4 rounded-xl shadow">
        <p class="text-sm text-gray-500">Total Pesanan</p>
        <h3 class="text-xl font-semibold">{{ $totalOrders }} Pesanan</h3>
    </div>
    <div class="bg-white p-4 rounded-xl shadow">
        <p class="text-sm text-gray-500">Total Produk</p>
        <h3 class="text-xl font-semibold">{{ $totalProducts }} Produk</h3>
    </div>
    <div class="bg-white p-4 rounded-xl shadow">
        <p class="text-sm text-gray-500">Total Pendapatan</p>
        <h3 class="text-xl font-semibold">Rp. {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
    </div>
</div>
