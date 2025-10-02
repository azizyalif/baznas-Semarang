<?

namespace App\Http\Controllers;

use App\Exports\ExportProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Models\Proposal;
use App\Models\Bantuan;
use App\Models\Pekerjaan;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Program;
use App\Models\Arsip;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class KecamatanController extends Controller
{
    public function getKecamatan(Request $request)
    {
        $listKecamatan = Kecamatan::all();
        $proposals = Proposal::all();
        $kecamatan = DB::table('proposal as p')
            ->select('p.kecamatan as kecamatan', DB::raw('COUNT(p.id) as jumlah'))
            ->join('kecamatan as k', 'k.nama', '=', 'p.kecamatan')
            ->where('p.dibantu', '2')
            ->groupBy('k.nama')
            ->orderBy('jumlah', 'asc')
            ->get();
        $kecamatan_labels = [];
        $kecamatan_data = [];

        foreach ($kecamatan as $row) {
            $kecamatan_labels[] = $row->kecamatan;
            $kecamatan_data[] = $row->jumlah;
        }
        return response()->json([
            'labels' => $kecamatan_labels,
            'data' => $kecamatan_data
        ]);
    }
}
