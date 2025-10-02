<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Program;
use Illuminate\Http\Request;
use App\Models\DataFeed;

class DataFeedController extends Controller
{
    public function getDataFeed(Request $request)
    {
         $df = new DataFeed();
        return (object)[
            'labels' => $df->getDataFeed(
                $request->datatype,
                'label',
                $request->limit
            ),
            'data' => $df->getDataFeed(
                $request->datatype,
                'data',
                $request->limit
            ),
        ];
    }

}
