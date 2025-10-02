<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Proposal;
use App\Models\Rekap;
use Illuminate\Contracts\View\View;

class ExportRekap implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $rekaps = Rekap::all();
        $total_proposal = Proposal::count();
        $total_dibantu = Proposal::where('dibantu', '2')->count();
        $total_belum_arsip = Proposal::where('dibantu', '1')->count();
        return view('rekaps.table-program', compact('rekaps', 'total_proposal', 'total_dibantu', 'total_belum_arsip'));
    }
}
