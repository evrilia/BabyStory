@extends('layouts.admin')

@section('content')

            <div class="bg-[#B7E4FF] rounded-2xl shadow-md p-6 mt-6">
                <div class="bg-white rounded-2xl shadow-md p-8">
                    <h2 class="text-xl font-semibold mb-2">Statistik</h2>
                    <p class="text-sm text-gray-600 mb-6">Home > Statistik</p>

                    <!-- Tombol Bulan / Tahun -->
                    <div class="flex justify-center gap-4 mb-6">
                        <a href="{{ route('admin.statistics.index', ['mode' => 'bulan']) }}"
                            class="px-6 py-2 rounded-md font-medium {{ $mode == 'bulan' ? 'bg-pink-400 text-white' : 'bg-gray-200 text-gray-700' }}">
                            BULAN
                        </a>
                        <a href="{{ route('admin.statistics.index', ['mode' => 'tahun']) }}"
                            class="px-6 py-2 rounded-md font-medium {{ $mode == 'tahun' ? 'bg-pink-400 text-white' : 'bg-gray-200 text-gray-700' }}">
                            TAHUN
                        </a>
                    </div>

                    <!-- Chart -->
                    <div class="bg-[#F9FAFB] rounded-lg p-4 shadow-inner mb-8">
                        <h3 class="font-semibold mb-4">
                            Statistik dalam {{ ucfirst($mode) }}
                        </h3>
                        <canvas id="chart"></canvas>
                    </div>

                    <!-- Tabel -->
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-200 text-sm text-center">
                            <thead class="bg-pink-200 text-gray-700">
                                <tr>
                                    @if ($mode == 'bulan')
                                        <th class="border p-2">Nama Bulan</th>
                                    @else
                                        <th class="border p-2">Tahun</th>
                                    @endif
                                    <th class="border p-2">Produk Terlaris</th>
                                    <th class="border p-2">Jumlah Transaksi</th>
                                    <th class="border p-2">Total Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($statistics as $stat)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border p-2">{{ $mode == 'bulan' ? $stat->bulan : $stat->tahun }}</td>
                                        <td class="border p-2">{{ $stat->produk_terlaris }}</td>
                                        <td class="border p-2">{{ $stat->jumlah_transaksi }}</td>
                                        <td class="border p-2">Rp. {{ number_format($stat->total_pendapatan, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chart').getContext('2d');
        const mode = @json($mode);

        const data = {
            labels: @json($labels),
            datasets: [{
                label: 'Total Pendapatan',
                data: @json($values),
                backgroundColor: mode === 'bulan' ? '#F9A8D4' : 'rgba(255, 205, 86, 0.5)',
                borderColor: mode === 'tahun' ? '#FDE047' : undefined,
                borderWidth: 2,
                borderRadius: 6,
                tension: 0.3,
                pointBackgroundColor: '#FDE047',
                pointRadius: 8,
                type: mode === 'tahun' ? 'line' : 'bar',
            }]
        };

        new Chart(ctx, {
            type: mode === 'tahun' ? 'line' : 'bar',
            data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => 'Rp ' + value.toLocaleString('id-ID')
                        }
                    }
                }
            }
        });
    </script>
@endsection
