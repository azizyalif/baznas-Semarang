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

class ProgramController extends Controller
{
    public function getProgram(Request $request)
    {
        $proposals = Proposal::all();
        $listProgram = Program::all();
        $program = DB::table('proposal as p')
            ->select('p.keterangan as program', DB::raw('COUNT(p.id) as jumlah'))
            ->join('program as g', 'g.nama', '=', 'p.keterangan')
            ->where('p.dibantu', '2')
            ->groupBy('g.nama')
            ->orderBy('jumlah', 'asc')
            ->get();
        $program_labels = [];
        $program_data = [];

        foreach ($program as $row) {
            $program_labels[] = $row->program;
            $program_data[] = $row->jumlah;
        }
        return response()->json([
            'labels' => $program_labels,
            'data' => $program_data
        ]);
    }
}
