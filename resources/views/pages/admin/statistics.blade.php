@extends('layouts.admin')

@section('content')
    <div class="flex min-h-screen bg-white-50">
        <div class="flex-1 p-6">

            <div class="bg-[#B7E4FF] rounded-2xl shadow-md p-6 mt-6">
                <div class="bg-white rounded-2xl shadow-md p-8">
                    <h2 class="text-xl font-semibold mb-2">Statistik Penjualan</h2>
                    <p class="text-sm text-gray-600 mb-6">Home > Statistik</p>

                    <div class="flex justify-center gap-4 mb-6">
                        <a href="{{ route('admin.statistics.index', ['mode' => 'bulan']) }}"
                            class="px-6 py-2 rounded-md font-medium transition {{ $mode == 'bulan' ? 'bg-pink-400 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            BULAN
                        </a>
                        <a href="{{ route('admin.statistics.index', ['mode' => 'tahun']) }}"
                            class="px-6 py-2 rounded-md font-medium transition {{ $mode == 'tahun' ? 'bg-pink-400 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            TAHUN
                        </a>
                    </div>

                    <div class="bg-[#F9FAFB] rounded-lg p-4 shadow-inner mb-8">
                        <h3 class="font-semibold mb-4 text-center text-gray-700">
                            Grafik Pendapatan ({{ ucfirst($mode) }})
                        </h3>
                        <canvas id="chart" height="100"></canvas>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-200 text-sm text-center">
                            <thead class="bg-pink-200 text-gray-700">
                                <tr>
                                    @if ($mode == 'bulan')
                                        <th class="border p-3">Bulan</th>
                                    @else
                                        <th class="border p-3">Tahun</th>
                                    @endif
                                    <th class="border p-3">Produk Terlaris</th>
                                    <th class="border p-3">Jumlah Transaksi</th>
                                    <th class="border p-3">Total Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($statistics as $stat)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border p-3 font-medium">
                                            {{ $mode == 'bulan' ? $stat->bulan : $stat->tahun }}
                                        </td>
                                        <td class="border p-3">{{ $stat->produk_terlaris }}</td>
                                        <td class="border p-3">{{ $stat->jumlah_transaksi }}</td>
                                        <td class="border p-3 font-bold text-green-600">
                                            Rp {{ number_format($stat->total_pendapatan, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-4 text-center text-gray-500">Belum ada data transaksi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('chart').getContext('2d');
            const mode = @json($mode);
            const labels = @json($labels);
            const values = @json($values);

            const data = {
                labels: labels,
                datasets: [{
                    label: 'Total Pendapatan',
                    data: values,
                    backgroundColor: mode === 'bulan' ? 'rgba(244, 114, 182, 0.6)' : 'rgba(250, 204, 21, 0.6)',
                    borderColor: mode === 'bulan' ? '#ec4899' : '#eab308',
                    borderWidth: 2,
                    borderRadius: 4,
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#eab308',
                    pointRadius: 5,
                    type: mode === 'tahun' ? 'line' : 'bar',
                }]
            };

            new Chart(ctx, {
                type: mode === 'tahun' ? 'line' : 'bar',
                data: data,
                options: {
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    let label = context.dataset.label || '';
                                    if (label) label += ': ';
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection