@extends('layouts.admin')

@section('content')
    <div class="flex min-h-screen bg-white-50">

        <div class="flex-1 p-6">

            <div class="bg-[#B7E4FF] rounded-2xl shadow-md p-6 mt-6">
                <h2 class="text-2xl font-semibold mb-2 text-gray-800">Dashboard</h2>
                <p class="text-sm text-gray-600 mb-4">Home > Dashboard</p>

                @include('pages.admin.cards')

                <div class="bg-white rounded-2xl p-4 shadow mt-6">
                    <h3 class="text-lg font-semibold mb-3">Pesanan Terbaru</h3>
                    <table class="w-full text-sm text-left text-gray-700 border-t border-gray-300">
                        <thead class="border-b border-gray-300">
                            <tr class="text-gray-600">
                                <th class="py-2">ID Pesanan</th>
                                <th>Nama Pelanggan</th>
                                <th>Produk</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($latestOrders as $order)
                                <tr class="border-b">
                                    <td class="py-2">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                                    {{-- PERBAIKAN: Gunakan kolom string langsung --}}
                                    <td>{{ $order->nama_pelanggan }}</td>
                                    <td>{{ $order->nama_produk }}</td>
                                    {{-- Gunakan created_at --}}
                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M y') }}</td>
                                    <td>
                                        <span class="px-2 py-1 rounded text-xs font-bold 
                                        {{ $order->status == 'Selesai' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td>Rp. {{ number_format($order->total, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection