<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DataFeed;
use App\Models\Proposal;

class DashboardController extends Controller
{
    public function index()
    {

        $dataFeed = new DataFeed();
        $proposals = Proposal::all();
        $totalDibantu = Proposal::where('dibantu', '2')->count();
        $total = Proposal::all()->count();

        $statusOptions = [
            '' => 'Semua Status',
            '0' => 'Belum Diproses',
            '1' => 'Sedang Diproses',
            '2' => 'Sudah Dibantu'
        ];
        $programData = DB::table('proposals')
            ->select('keterangan', DB::raw('count(*) as jumlah'))
            ->groupBy('keterangan')
            ->get();

        $programLabels = $programData->pluck('keterangan')->toArray();
        $programDataArr = $programData->pluck('jumlah')->toArray();
        return view('pages/dashboard/dashboard', compact('dataFeed', 'proposals', 'statusOptions', 'programLabels', 'programData', 'totalDibantu', 'total'));
    }
    public function getChartData()
    {
        
        $kecamatanData = DB::table('proposals')
            ->select('kecamatan', DB::raw('count(*) as jumlah'))
            ->groupBy('kecamatan')
            ->get();

        $programData = DB::table('proposals')
            ->select('keterangan', DB::raw('count(*) as jumlah'))
            ->groupBy('keterangan')
            ->get();

        return response()->json([
            'kecamatan' => [
                'labels' => $kecamatanData->pluck('kecamatan')->toArray(),
                'data' => $kecamatanData->pluck('jumlah')->toArray()
            ],
            'program' => [
                'labels' => $programData->pluck('keterangan')->toArray(),
                'data' => $programData->pluck('jumlah')->toArray()
            ]
        ]);
    }
    /**
     * Displays the analytics screen
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function analytics()
    {
        return view('pages/dashboard/analytics');
    }

    /**
     * Displays the fintech screen
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function fintech()
    {
        return view('pages/dashboard/fintech');
    }
    public function logout()
    {
        return view('login');
    }
}
