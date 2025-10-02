<?php

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
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class ProposalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the proposals.
     */
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'super_admin' && Auth::user()->role !== 'operator') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }
        $search = $request->get('search', '');
        $status = $request->get('status', '');
        $proposals = Proposal::paginate(10);
        $totalDibantu = Proposal::where('dibantu', '2')->count();
        $total = Proposal::all()->count();

        $statusOptions = [
            '' => 'Semua Status',
            '0' => 'Belum Diproses',
            '1' => 'Sedang Diproses',
            '2' => 'Sudah Dibantu'
        ];

        return view('proposals.index', compact('proposals', 'total', 'search', 'status', 'statusOptions', 'totalDibantu'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'super_admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }
        $pekerjaan = Pekerjaan::all();
        $kecamatan = Kecamatan::orderBy('nama')->get();
        $kelurahan = Kelurahan::orderBy('nama')->get();
        $program = Program::orderBy('id')->get();
        $jenisPermohonan = Bantuan::orderBy('id')->get();

        return view('proposals.create', compact(
            'pekerjaan',
            'kecamatan',
            'kelurahan',
            'program',
            'jenisPermohonan'
        ));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'super_admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }
        try {
            
            $validatedData = $request->validate([
                'agenda' => 'required|string',
                'kode' => 'required|string',
                'program' => 'required|exists:programs,id',
                'jumlah' => 'required|integer|min:1',
                'proposalmasuk' => 'required|date',
                'instansi' => 'nullable|string',
                'pimpinan' => 'nullable|string',
                'pemohon' => 'required|string',
                'jk' => 'required|in:L,P',
                'anak' => 'nullable|string',
                'nik' => 'required|string|unique:proposals,nik',
                'ttl' => 'required|string',
                'alamat' => 'required|string',
                'kelurahan' => 'required|exists:kelurahans,id',
                'kecamatan' => 'required|exists:kecamatans,id',
                'jenisPermohonan' => 'required|exists:bantuans,id',
                'kerja' => 'required|exists:pekerjaans,id',
                'hp' => 'required|string',
                'waktu' => 'required|date_format:H:i',
                'pengaju' => 'required|string',
                'penyerahan' => 'nullable|string',
                'realisasi' => 'nullable|string',
            ]);

            
            $existingProposal = Proposal::where('nik', $validatedData['nik'])->first();

            if ($existingProposal) {
                return response()->json([
                    'error' => "Peringatan: NIK {$existingProposal->nik} sudah pernah diajukan oleh {$existingProposal->nm_pemohon} untuk jenis permohonan {$existingProposal->jns_permohonan}."
                ], 400);
            }

            
            $program = Program::find($validatedData['program']);
            $jenisPermohonan = Bantuan::find($validatedData['jenisPermohonan']);
            $kelurahan = Kelurahan::find($validatedData['kelurahan']);
            $kecamatan = Kecamatan::find($validatedData['kecamatan']);
            $pekerjaan = Pekerjaan::find($validatedData['kerja']);

            
            $proposal = Proposal::create([
                'id' => $validatedData['agenda'],
                'kode' => $validatedData['kode'],
                'keterangan' => $program->nama_program,
                'jml_proposal' => $validatedData['jumlah'],
                'tgl_masuk' => $validatedData['proposalmasuk'],
                'nm_instansi' => $validatedData['instansi'],
                'nm_pimpinan' => $validatedData['pimpinan'],
                'nm_pemohon' => $validatedData['pemohon'],
                'jns_kelamin' => $validatedData['jk'],
                'nm_anak' => $validatedData['anak'],
                'nik' => $validatedData['nik'],
                'ttl' => $validatedData['ttl'],
                'alamat' => $validatedData['alamat'],
                'kelurahan' => $kelurahan->nama,
                'kecamatan' => $kecamatan->nama,
                'pekerjaan' => $pekerjaan->nama,
                'jns_permohonan' => $jenisPermohonan->jns_bantuan,
                'no_telp' => $validatedData['hp'],
                'jam_pengajuan' => $validatedData['waktu'],
                'pengaju' => $validatedData['pengaju'],
                'penyerahan' => $validatedData['penyerahan'],
                'realisasi' => $validatedData['realisasi'],
            ]);

            if ($request->ajax()) {
                return response()->json(['message' => 'success']);
            }

            return redirect()->route('proposals.index')->with('success', 'Proposal berhasil disimpan!');
        } catch (ValidationException $e) {
            if ($request->ajax()) {
                return response()->json(['errors' => $e->errors()], 422);
            }

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function show(Proposal $proposal)
    {
        $totalDibantu = Proposal::where('dibantu', 2)->count();
        return view('proposal.show', compact('proposal'));
    }

    public function edit($id)
    {
        if (Auth::user()->role !== 'Admin' && Auth::user()->role !== 'super_admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }
        $proposal = Proposal::findOrFail($id);
        $pekerjaan = Pekerjaan::all();
        $kecamatan = Kecamatan::orderBy('nama')->get();
        $kelurahan = Kelurahan::orderBy('nama')->get();
        $program = Program::orderBy('id')->get();
        $jenisPermohonan = Bantuan::orderBy('id')->get();

        return view('proposals.edit', compact(
            'proposal',
            'pekerjaan',
            'kecamatan',
            'kelurahan',
            'program',
            'jenisPermohonan'
        ));
    }
    public function proses(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'super_admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }
        $proposal = Proposal::findOrFail($id);
        $proposal->dibantu = '1';
        $proposal->save();
        return view('proposals.proses', compact('proposal'));
    }
    public function process(Request $request)
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'super_admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }
        $proposal = Proposal::where('dibantu', '0')->update(['dibantu' => '1']);
        if ($proposal) {
            return redirect()->route('proposal')->with('success', 'Proposal berhasil diproses!');
        } else {
            return redirect()->route('proposal')->with('error', 'Tidak ada proposal yang diproses.');
        }
    }


    public function update(Request $request, Proposal $proposal, $id)
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'super_admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }
        try {
            $proposal = Proposal::findOrFail($id);
            $validatedData = $request->validate([
                'agenda' => 'required|string',
                'kode' => 'required|string',
                'kelurahan' => 'required|exists:kelurahans,id',
                'kecamatan' => 'required|exists:kecamatans,id',
                'program' => 'required|exists:programs,id',
                'jenisPermohonan' => 'required|exists:bantuans,id',
                'jumlah' => 'required|integer|min:1',
                'proposalmasuk' => 'required|date',
                'instansi' => 'nullable|string',
                'pimpinan' => 'nullable|string',
                'pemohon' => 'required|string',
                'jk' => 'required|in:L,P',
                'anak' => 'nullable|string',
                'ttl' => 'required|string',
                'alamat' => 'required|string',
                'kerja' => 'required|exists:pekerjaans,id',
                'hp' => 'required|string',
                'waktu' => 'required|date_format:H:i',
                'pengaju' => 'required|string',
                'penyerahan' => 'nullable|string',
                'realisasi' => 'nullable|string',
                'nominal' => 'required|string',
                'ket_realisasi' => 'nullable|string',
                'follup' => 'required|string',

            ]);

            $programModel = Program::find($validatedData['program']);
            $jenisPermohonanModel = Bantuan::find($validatedData['jenisPermohonan']);
            $kelurahanModel = Kelurahan::find($validatedData['kelurahan']);
            $kecamatanModel = Kecamatan::find($validatedData['kecamatan']);
            $pekerjaanModel = Pekerjaan::find($validatedData['kerja']);

            
            $proposal->update([
                'id' => $validatedData['agenda'],
                'kode' => $validatedData['kode'],
                'keterangan' => $programModel->nama_program,
                'jml_proposal' => $validatedData['jumlah'],
                'tgl_masuk' => $validatedData['proposalmasuk'],
                'nm_instansi' => $validatedData['instansi'],
                'nm_pimpinan' => $validatedData['pimpinan'],
                'nm_pemohon' => $validatedData['pemohon'],
                'jns_kelamin' => $validatedData['jk'],
                'nm_anak' => $validatedData['anak'],
                'ttl' => $validatedData['ttl'],
                'alamat' => $validatedData['alamat'],
                'kelurahan' => $kelurahanModel->nama,
                'kecamatan' => $kecamatanModel->nama,
                'pekerjaan' => $pekerjaanModel->nama,
                'jns_permohonan' => $jenisPermohonanModel->jns_bantuan,
                'no_telp' => $validatedData['hp'],
                'jam_pengajuan' => $validatedData['waktu'],
                'pengaju' => $validatedData['pengaju'],
                'penyerahan' => $validatedData['penyerahan'],
                'realisasi' => $validatedData['realisasi'],
                'nominal' => $validatedData['nominal'],
                'keterangan_realisasi' => $validatedData['ket_realisasi'],
                'dibantu' => $validatedData['follup'],
            ]);
            $proposal->save();
            if ($request->ajax()) {
                return response()->json(['message' => 'success']);
            }

            return redirect()->route('proposal.index')->with('success', 'Proposal berhasil diupdate!');
        } catch (ValidationException $e) {
            if ($request->ajax()) {
                return response()->json(['errors' => $e->errors()], 422);
            }

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }
    public function delete($id)
    {
        if (Auth::user()->role !== 'operator') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }
        try {
            $proposal = Proposal::findOrFail($id);
            $proposal->delete();

            return redirect()->back()->with('success', 'Proposal berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus proposal: ' . $e->getMessage());
        }
    }
    public function destroy(Proposal $proposal)
    {   
        if (Auth::user()->role !== 'operator') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }
        try {
            DB::beginTransaction();

            $proposals = Proposal::select('nik', 'nm_pemohon', 'jns_permohonan', 'tgl_masuk')->get();

            foreach ($proposals as $item) {
                Arsip::create([
                    'nik'       => $item->nik,
                    'nama'      => $item->nm_pemohon,
                    'bantuan'   => $item->jns_permohonan,
                    'tahun'     => (string) date('Y', strtotime($item->tgl_masuk)),
                ]);
            }

            Proposal::truncate();

            DB::commit();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengarsipkan data: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Data proposal berhasil diarsipkan dan dihapus.');
    }

    public function getKelurahan($kecamatanId)
    {
        $kelurahan = Kelurahan::where('id_kecamatan', $kecamatanId)->get();
        return response()->json($kelurahan);
    }

    public function getJenisPermohonan($programId)
    {
        $jenisPermohonan = Bantuan::where('id_program', $programId)->get();
        return response()->json($jenisPermohonan);
    }
    public function dibantu(Request $request)
    {
        $search = $request->get('search', '');
        $status = $request->get('status', '');
        $proposals = Proposal::where('dibantu', '2')->paginate(10);

        $totalDibantu = Proposal::where('dibantu', '2')->count();

        $statusOptions = [
            '' => 'Semua Status',
            '0' => 'Belum Diproses',
            '1' => 'Sedang Diproses',
            '2' => 'Sudah Dibantu'
        ];

        return view('proposals.dibantu', compact('proposals', 'totalDibantu', 'search', 'status', 'statusOptions'));
    }
    public function download()
    {
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML('<h1>Hello world!</h1>');
        $mpdf->Output();
    }
    public function export_excel()
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'super_admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }
        $proposals = new Proposal();
        $proposals = Proposal::all();
        $timestamp = now()->format('Ymd_His');
        return Excel::download(new ExportProposal, "proposal_{$timestamp}.xlsx");
    }
    public function dibantu_excel()
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'super_admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }
        $proposals = new Proposal();
        $proposals = Proposal::where('dibantu', '2')->get();
        $timestamp = now()->format('Ymd_His');
        return Excel::download(new ExportProposal, "proposal_dibantu_{$timestamp}.xlsx");
    }
    public function showDisposisi($id)
    {
        $proposal = Proposal::findOrFail($id);
        setlocale(LC_TIME, 'id_ID.utf8', 'id_ID', 'id', 'indonesian');
        $tanggalFormat = strftime('%d %B %Y', strtotime($proposal->tgl_masuk));
        $surat = !empty($proposal->nm_instansi) ? $proposal->nm_instansi : $proposal->nm_pemohon;
        $perihal = !empty($proposal->nm_instansi) ? $proposal->jns_permohonan . " a.n " . $proposal->nm_pemohon : $proposal->jns_permohonan;
        $almt = (!empty($proposal->nm_instansi) && Program::where('nama_program', $proposal->keterangan)->where('id', 3)->exists())
            ? $proposal->nm_instansi
            : $proposal->alamat;
        return view('proposals.disposisi', compact('proposal', 'tanggalFormat', 'surat', 'perihal', 'almt'));
    }
    public function rekapJenis()
    {
        return view('rekaps.jenis');
    }
    public function getDataByKecamatan()
    {
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
    public function getDataByProgram()
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
