<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\KelasJurusan;
use App\Models\OrangTua;
use App\Models\PelanggaranSiswa;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';

    protected $fillable = [
        'foto',
        'nis', 
        'nama',
        'tanggal_lahir', 
        'no_hp', 
        'alamat',
        'user_id', 
        'kelas_jurusan_id',
        'orang_tuas_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelasJurusan()
    {
        return $this->belongsTo(KelasJurusan::class);
    }

    public function orangtua()
    {
        return $this->belongsTo(OrangTua::class, 'orang_tuas_id', 'id');
    }

        public function pelanggaransiswa()
    {
        return $this->hasMany(PelanggaranSiswa::class, 'siswas_id');
    }

}
