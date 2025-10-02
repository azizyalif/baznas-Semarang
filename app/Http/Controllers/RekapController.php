<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Rekap;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class RekapController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'super_admin' && Auth::user()->role !== 'operator') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }
        $limit = 5;
        $rekaps = Rekap::orderBy('id')->paginate($limit);
        $rekaps->getCollection()->transform(function ($rekap) {
            $kode = $rekap->kode;
            $rekap->total_proposal = Proposal::where('kode', $kode)->count();
            $rekap->total_dibantu = Proposal::where('kode', $kode)->where('dibantu', '2')->count();
            $rekap->total_belum_arsip = Proposal::where('kode', $kode)->where('dibantu', '1')->count();
            return $rekap;
        });
        $rekaps->setCollection($rekaps->getCollection());
        $total_proposal = Proposal::count();
        $total_dibantu = Proposal::where('dibantu', '2')->count();
        $total_belum_arsip = Proposal::where('dibantu', '1')->count();
        return view('rekaps.index', compact('rekaps', 'total_proposal', 'total_dibantu', 'total_belum_arsip'));
    }

    public function rekapProgram(Request $request)
    {
        $rekaps = Rekap::paginate(5); 
        $rekaps->getCollection()->transform(function ($rekap) {
            $kode = $rekap->kode;
            $rekap->total_proposal = Proposal::where('kode', $kode)->count();
            $rekap->total_dibantu = Proposal::where('kode', $kode)->where('dibantu', '2')->count();
            $rekap->total_belum_arsip = Proposal::where('kode', $kode)->where('dibantu', '1')->count();
            return $rekap;
        });
        $rekaps->setCollection($rekaps->getCollection());
        $total_proposal = Proposal::count();
        $total_dibantu = Proposal::where('dibantu', '2')->count();
        $total_belum_arsip = Proposal::where('dibantu', '1')->count();

        return view('rekaps.program', compact('rekaps', 'total_proposal', 'total_dibantu', 'total_belum_arsip'));
    }
    public function rekapJenis(Request $request)
    {
        $programs = DB::table('bantuans')->get();
        $tahun = date('Y');
        $data = [];
        $grandTotal = 0;
        $grandBulanCounts = array_fill(0, 12, 0);
        foreach ($programs as $program) {
            $jnsBantuan = $program->jns_bantuan;
            $totalRows = DB::table('proposals')
                ->where('jns_permohonan', $jnsBantuan)
                ->count();
            $bulanCounts = [];
            for ($bulan = 01; $bulan <= 12; $bulan++) {
                $bulanStr = str_pad($bulan, 2, '0', STR_PAD_LEFT);
                $jumlah = DB::table('proposals')
                    ->where('jns_permohonan', $jnsBantuan)
                    ->whereYear('tgl_masuk', $tahun)
                    ->whereMonth('tgl_masuk', $bulanStr)
                    ->count();
                $bulanCounts[] = $jumlah;
                $grandBulanCounts[$bulan - 1] += $jumlah;
            }
            $grandTotal += $totalRows;
            $namaProgram = '';
            switch ($program->id_program) {
                case 1:
                    $namaProgram = 'Semarang Peduli';
                    break;
                case 2:
                    $namaProgram = 'Semarang Sehat';
                    break;
                case 3:
                    $namaProgram = 'Semarang Cerdas';
                    break;
                case 4:
                    $namaProgram = 'Semarang Taqwa';
                    break;
                case 5:
                    $namaProgram = 'Semarang Makmur';
                    break;
                default:
                    $namaProgram = 'Program Tidak Diketahui';
                    break;
            }
            $data[] = [
                'nama_program' => $namaProgram,
                'jns_bantuan' => $jnsBantuan,
                'total' => $totalRows,
                'bulan_counts' => $bulanCounts,
            ];
        }

        return view('rekaps.jenis', compact('data', 'grandTotal', 'grandBulanCounts'));
    }
    public function jenis_excel()
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'super_admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }
        $programs = DB::table('bantuans')->get();
        $tahun = date('Y');
        $data = [];
        $grandTotal = 0;
        $grandBulanCounts = array_fill(0, 12, 0);
        foreach ($programs as $program) {
            $jnsBantuan = $program->jns_bantuan;
            $totalRows = DB::table('proposals')
                ->where('jns_permohonan', $jnsBantuan)
                ->count();
            $bulanCounts = [];
            for ($bulan = 01; $bulan <= 12; $bulan++) {
                $bulanStr = str_pad($bulan, 2, '0', STR_PAD_LEFT);
                $jumlah = DB::table('proposals')
                    ->where('jns_permohonan', $jnsBantuan)
                    ->whereYear('tgl_masuk', $tahun)
                    ->whereMonth('tgl_masuk', $bulanStr)
                    ->count();
                $bulanCounts[] = $jumlah;
                $grandBulanCounts[$bulan - 1] += $jumlah;
            }
            $grandTotal += $totalRows;
            $namaProgram = '';
            switch ($program->id_program) {
                case 1:
                    $namaProgram = 'Semarang Peduli';
                    break;
                case 2:
                    $namaProgram = 'Semarang Sehat';
                    break;
                case 3:
                    $namaProgram = 'Semarang Cerdas';
                    break;
                case 4:
                    $namaProgram = 'Semarang Taqwa';
                    break;
                case 5:
                    $namaProgram = 'Semarang Makmur';
                    break;
                default:
                    $namaProgram = 'Program Tidak Diketahui';
                    break;
            }
            $data[] = [
                'nama_program' => $namaProgram,
                'jns_bantuan' => $jnsBantuan,
                'total' => $totalRows,
                'bulan_counts' => $bulanCounts,
            ];
        }

        
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Jenis Bantuan');
        $sheet->setCellValue('C1', 'Total Proposal');
        $sheet->setCellValue('D1', 'Jan');
        $sheet->setCellValue('E1', 'Feb');
        $sheet->setCellValue('F1', 'Mar');
        $sheet->setCellValue('G1', 'Apr');
        $sheet->setCellValue('H1', 'Mei');
        $sheet->setCellValue('I1', 'Jun');
        $sheet->setCellValue('J1', 'Jul');
        $sheet->setCellValue('K1', 'Agu');
        $sheet->setCellValue('L1', 'Sep');
        $sheet->setCellValue('M1', 'Okt');
        $sheet->setCellValue('N1', 'Nov');
        $sheet->setCellValue('O1', 'Des');
        $row = 2;
        foreach ($data as $index => $item) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $item['jns_bantuan']);
            $sheet->setCellValue('C' . $row, $item['total']);
            for ($bulan = 0; $bulan < 12; $bulan++) {
                $sheet->setCellValueByColumnAndRow(4 + $bulan, $row, $item['bulan_counts'][$bulan]);
            }
            $row++;
        }
        $sheet->setCellValue('A' . $row, 'TOTAL');
        $sheet->setCellValue('C' . $row, $grandTotal);
        for ($bulan = 0; $bulan < 12; $bulan++) {
            $sheet->setCellValueByColumnAndRow(4 + $bulan, $row, $grandBulanCounts[$bulan]);
        }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="rekap-jenis-bantuan.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
    public function export_excel()
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'super_admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }
        $rekaps = Rekap::all();
        $rekaps->transform(function ($rekap) {
            $kode = $rekap->kode;
            $rekap->total_proposal = Proposal::where('kode', $kode)->count();
            $rekap->total_dibantu = Proposal::where('kode', $kode)->where('dibantu', '2')->count();
            $rekap->total_belum_arsip = Proposal::where('kode', $kode)->where('dibantu', '1')->count();
            return $rekap;
        });

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode');
        $sheet->setCellValue('C1', 'Nama Program');
        $sheet->setCellValue('D1', 'Total Proposal');
        $sheet->setCellValue('E1', 'Total Dibantu');
        $sheet->setCellValue('F1', 'Total Belum Arsip');
        $row = 2;
        foreach ($rekaps as $index => $rekap) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $rekap->kode);
            $sheet->setCellValue('C' . $row, $rekap->nama_program);
            $sheet->setCellValue('D' . $row, $rekap->total_proposal);
            $sheet->setCellValue('E' . $row, $rekap->total_dibantu);
            $sheet->setCellValue('F' . $row, $rekap->total_belum_arsip);
            $row++;
        }
        $sheet->setCellValue('A' . $row, 'TOTAL');
        $sheet->setCellValue('D' . $row, '=SUM(D2:D' . ($row - 1) . ')');
        $sheet->setCellValue('E' . $row, '=SUM(E2:E' . ($row - 1) . ')');
        $sheet->setCellValue('F' . $row, '=SUM(F2:F' . ($row - 1) . ')');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="rekap-program.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
}
