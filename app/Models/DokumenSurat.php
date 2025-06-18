<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenSurat extends Model
{
    use HasFactory;
    protected $table = 'dokumen_surat';
    protected $fillable = ['kode_surat','jenis_surat', 'tanggal_pembuatan', 'keterangan', 'status','link_file', 'ttd_kepsek'];


    public function suratKeluar()
    {
        return $this->hasOne(SuratKeluar::class, 'dokumen_surat_id');
    }
    
}
