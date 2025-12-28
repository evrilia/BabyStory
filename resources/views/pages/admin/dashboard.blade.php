@extends('layouts.admin')

@section('content')
    <div class="flex min-h-screen bg-white-50">

        <div class="flex-1 p-6">

            <div class="bg-[#B7E4FF] rounded-2xl shadow-md p-6 mt-6">
                {{-- Header Dashboard dengan Judul dan Tombol Trigger --}}
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                    <div>
                        <h2 class="text-2xl font-semibold mb-2 text-gray-800">Dashboard</h2>
                        <p class="text-sm text-gray-600">Home > Dashboard</p>
                    </div>

                    {{-- Tombol Trigger Email Manual --}}
                    <form action="{{ route('admin.trigger.reminder') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="bg-[#0077B6] hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-full shadow-lg transition duration-300 flex items-center gap-2">
                            <i class="fas fa-paper-plane"></i>
                            Kirim Reminder
                        </button>
                    </form>
                </div>

                {{-- Alert Notifikasi Sukses/Gagal --}}
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm animate-pulse"
                        role="alert">
                        <p class="font-bold">Berhasil!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
                        <p class="font-bold">Gagal!</p>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                {{-- Bagian Cards Statistik --}}
                @include('pages.admin.cards')

                {{-- Tabel Pesanan Terbaru --}}
                <div class="bg-white rounded-2xl p-4 shadow mt-6">
                    <h3 class="text-lg font-semibold mb-3">Pesanan Terbaru</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-700 border-t border-gray-300">
                            <thead class="border-b border-gray-300">
                                <tr class="text-gray-600">
                                    <th class="py-3 px-2">ID Pesanan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Produk</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($latestOrders as $order)
                                    <tr class="border-b hover:bg-gray-50 transition">
                                        <td class="py-3 px-2">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $order->nama_pelanggan }}</td>
                                        <td>{{ $order->nama_produk }}</td>
                                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M y') }}</td>
                                        <td>
                                            <span
                                                class="px-2 py-1 rounded text-xs font-bold 
                                                        {{ $order->status == 'Selesai' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td class="font-semibold text-gray-800">Rp
                                            {{ number_format($order->total, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection