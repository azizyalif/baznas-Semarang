<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Arsip extends Model
{
    use HasFactory;
    protected $table = 'arsips';
    public $timestamps = false;
    protected $fillable = ['nik', 'nama', 'bantuan', 'tahun'];
    protected $guarded = ['nik'];
}
