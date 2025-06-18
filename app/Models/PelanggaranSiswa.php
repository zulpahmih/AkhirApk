<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Siswa;
use App\Models\KelasJurusan;
use App\Models\DataPointPelanggaran;
use App\Models\TataTertib;

class PelanggaranSiswa extends Model
{
    use HasFactory;

    protected $table = 'pelanggaran_siswas';

    protected $fillable = [
        'siswas_id',
        'kelas_jurusan_id',
        'tata_tertib_id',
        'data_point_pelanggarans_id',
        'tanggal_pelanggaran',
        'foto',
    ];

    public function siswa() {
        return $this->belongsTo(Siswa::class, 'siswas_id');
    }

    public function kelasJurusan() {
        return $this->belongsTo(KelasJurusan::class, 'kelas_jurusan_id');
    }

    public function tataTertib() {
        return $this->belongsTo(tata_tertib::class, 'tata_tertib_id', 'id');
    }

    public function dataPointPelanggaran() {
        return $this->belongsTo(DataPointPelanggaran::class, 'data_point_pelanggarans_id');
    }
}
