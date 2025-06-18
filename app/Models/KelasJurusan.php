<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\WaliKelas;
use App\Models\Siswa;

class KelasJurusan extends Model
{
    use HasFactory;

    protected $table = 'kelas_jurusans';

    protected $fillable = [
        'kelas_id',
        'jurusan_id',
    ];

    // Relasi ke tabel Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    // Relasi ke tabel Jurusan
    public function jurusan()
    {
        return $this->belongsTo(jurusan::class);
    }

    // Relasi ke tabel WaliKelas
    public function waliKelas()
    {
        return $this->hasOne(WaliKelas::class, 'kelas_jurusan_id');
    }

    // Relasi ke tabel Siswa
    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }
    
}
