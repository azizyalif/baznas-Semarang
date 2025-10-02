<?php

namespace App\Exports;

use App\Models\Proposal;
use App\Http\Controllers\ProposalController;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ExportProposal implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View
    {
        $proposals = Proposal::all();
        return view('components.table', compact('proposals'));
    }
}
