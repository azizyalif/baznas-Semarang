<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Proposal extends Model
{
    use HasFactory;
    protected $table = 'proposals';
    protected $guarded = ['nik'];
    public $timestamps = false;
    protected $fillable = [
        'id',
        'kode',
        'keterangan',
        'jml_proposal',
        'tgl_masuk',
        'nm_instansi',
        'nm_pimpinan',
        'nm_pemohon',
        'jns_kelamin',
        'nm_anak',
        'nik',
        'ttl',
        'alamat',
        'kelurahan',
        'kecamatan',
        'pekerjaan',
        'jns_permohonan',
        'no_telp',
        'jam_pengajuan',
        'pengaju',
        'penyerahan',
        'realisasi',
        'nominal',
        'keterangan_realisasi',
        'dibantu',
    ];

    protected $dates = [
        'tgl_masuk',
    ];

    protected $casts = [
        'tgl_masuk' => 'date',
        'jam_pengajuan' => 'datetime:H:i:s',
        'jml_proposal' => 'integer',
        'dibantu' => 'string',
    ];

    public function scopeSearch($query, $search)
    {
        if (!empty($search)) {
            return $query->where(function ($q) use ($search) {
                $q->where('nik', 'LIKE', "%{$search}%")
                    ->orWhere('nm_pemohon', 'LIKE', "%{$search}%")
                    ->orWhere('kecamatan', 'LIKE', "%{$search}%")
                    ->orWhere('nm_instansi', 'LIKE', "%{$search}%")
                    ->orWhere('jns_permohonan', 'LIKE', "%{$search}%");
            });
        }

        return $query;
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('dibantu', $status);
    }

    public function getFormattedTglMasukAttribute()
    {
        return $this->tgl_masuk ? $this->tgl_masuk->format('Y-m-d') : null;
    }
    public function getStatusDibantuAttribute()
    {
        switch ($this->dibantu) {
            case '0':
                return 'Belum Diproses';
            case '1':
                return 'Sedang Diproses';
            case '2':
                return 'Sudah Dibantu';
            default:
                return 'Tidak Diketahui';
        }
    }

    public function getJenisKelaminAttribute()
    {
        return $this->jns_kelamin === 'L' ? 'Laki-laki' : ($this->jns_kelamin === 'P' ? 'Perempuan' : '');
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
        return view('components.dashboard.dashboard-card-04', [
            'program_labels' => $program_labels, 
            'program_data' => $program_data      
        ]);
    }
}
