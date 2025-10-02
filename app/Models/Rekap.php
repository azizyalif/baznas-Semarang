<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekap extends Model
{
    use HasFactory;
    protected $table = 'rekaps';
    public $timestamps = false;
    protected $fillable = ['kode', 'nama_program', 'bulan'];
}
