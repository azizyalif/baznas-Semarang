<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'kecamatans';
    protected $fillable = ['id', 'nama'];

    public function kelurahan()
    {
        return $this->hasMany(Kelurahan::class, 'id_kecamatan');
    }
    
}
