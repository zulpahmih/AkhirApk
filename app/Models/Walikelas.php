<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Guru;
use App\Models\KelasJurusan;


class Walikelas extends Model
{
    use HasFactory;
    
    protected $table = 'walikelas';

    protected $fillable = ['kelas_jurusan_id', 'guru_id'];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function kelasJurusan()
    {
        return $this->belongsTo(KelasJurusan::class, 'kelas_jurusan_id');
    }
    
}
