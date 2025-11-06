<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Statistic;
use App\Models\YearlyStatistic;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index(Request $request)
    {
        $mode = $request->get('mode', 'bulan'); // default: bulan

        if ($mode === 'tahun') {
            $statistics = YearlyStatistic::all();
            $labels = $statistics->pluck('tahun');
            $values = $statistics->pluck('total_pendapatan');
        } else {
            $statistics = Statistic::all();
            $labels = $statistics->pluck('bulan');
            $values = $statistics->pluck('total_pendapatan');
        }

        return view('pages.admin.statistics', compact('statistics', 'labels', 'values', 'mode'));
    }
}
