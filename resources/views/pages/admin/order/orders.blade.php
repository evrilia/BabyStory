@extends('layouts.admin')

@section('content')
    <div class="flex min-h-screen bg-gray-50">

        <div class="flex-1 p-6">

            <div class="bg-[#B7E4FF] rounded-2xl shadow-md p-6 mt-6">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">List Pesanan</h2>
                        <p class="text-sm text-gray-500">Home > List Pesanan</p>
                    </div>
                    <a href="{{ route('admin.orders.create') }}"
                        class="bg-pink-400 hover:bg-pink-500 text-white px-4 py-2 rounded-full text-sm font-semibold">
                        + Tambah Pesanan
                    </a>
                </div>

                <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                    <table class="w-full text-center">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="py-3">ID Pesanan</th>
                                <th>Nama Pelanggan</th>
                                <th>Produk</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach ($orders as $order)
                                                {{-- Tambahkan 'cursor-pointer' dan onclick agar baris bisa diklik --}}
                                                {{-- Asumsi: Anda ingin klik baris untuk melihat detail atau edit --}}
                                                <tr class="hover:bg-gray-50 cursor-pointer transition"
                                                    onclick="window.location='{{ route('admin.orders.edit', $order->id) }}'">

                                                    {{-- ID Pesanan (Gunakan $order->id dan format padding) --}}
                                                    <td class="py-3 px-4">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>

                                                    {{-- Nama Pelanggan (Sesuaikan dengan DB: nama_pelanggan) --}}
                                                    <td class="px-4">{{ $order->nama_pelanggan }}</td>

                                                    {{-- Nama Produk (Sesuaikan dengan DB: nama_produk) --}}
                                                    <td class="px-4">{{ $order->nama_produk }}</td>

                                                    {{-- Tanggal (Gunakan created_at) --}}
                                                    <td class="px-4">{{ \Carbon\Carbon::parse($order->created_at)->format('d M y') }}</td>

                                                    {{-- Status --}}
                                                    <td class="px-4">
                                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            {{ $order->status == 'Selesai' ? 'bg-green-100 text-green-700' :
                                ($order->status == 'Batal' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                                            {{ $order->status }}
                                                        </span>
                                                    </td>

                                                    {{-- Total --}}
                                                    <td class="px-4 font-medium">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-center mt-4">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection