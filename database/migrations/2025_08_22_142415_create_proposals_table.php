<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->integer('id');
            $table->string('kode', 7);
            $table->string('keterangan', 32);
            $table->integer('jml_proposal');
            $table->date('tgl_masuk');
            $table->string('nm_instansi', 256)->nullable();
            $table->string('nm_pimpinan', 256)->nullable();
            $table->string('nm_pemohon', 256);
            $table->enum('jns_kelamin', ['L', 'P'])->default('L');
            $table->string('nm_anak', 256)->nullable();
            $table->string('nik', 17)->primary();
            $table->string('ttl', 256);
            $table->text('alamat');
            $table->string('kelurahan', 256);
            $table->string('kecamatan', 256);
            $table->string('pekerjaan', 256);
            $table->string('jns_permohonan', 256);
            $table->string('no_telp', 14);
            $table->time('jam_pengajuan');
            $table->string('pengaju', 256)->nullable();
            $table->string('penyerahan', 256)->nullable();
            $table->string('realisasi', 256)->nullable();
            $table->string('nominal', 256)->nullable();
            $table->string('keterangan_realisasi', 256)->nullable();
            $table->enum('dibantu', ['0', '1', '2'])->default('0');
            $table->timestamps();
            
            $table->index(['nik', 'nm_pemohon', 'kecamatan']);
            $table->index('tgl_masuk');
            $table->index('dibantu');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
