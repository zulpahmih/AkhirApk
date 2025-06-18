<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'surat_keluar';
    protected $fillable = ['siswa_id', 'pelanggaran_siswa_id', 'dokumen_surat_id'];

    

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function pelanggaranSiswa()
    {
        return $this->belongsTo(PelanggaranSiswa::class, 'pelanggaran_siswa_id');
    }

    public function dokumenSurat()
    {
        return $this->belongsTo(DokumenSurat::class, 'dokumen_surat_id');
    }

    
}
