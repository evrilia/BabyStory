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
                                <tr class="hover:bg-gray-50">
                                    <td class="py-2">{{ $order->order_code }}</td>
                                    <td>{{ $order->customer_name }}</td>
                                    <td>{{ $order->product_name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M y') }}</td>
                                    <td>
                                        <span
                                            class="px-3 py-1 rounded-full text-sm
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

                <div class="flex justify-center mt-4">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
