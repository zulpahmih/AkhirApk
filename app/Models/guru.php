<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\WaliKelas;


class guru extends Model
{
    use HasFactory;

    protected $table = 'gurus';

    protected $fillable = ['foto','nip', 'nama','tanggal_lahir', 'jk', 'jabatan', 'no_hp', 'alamat', 'user_id',  'kelas_jurusan_id'];
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function waliKelas()
    {
        return $this->hasOne(WaliKelas::class, 'guru_id');
    }


}
