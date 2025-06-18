<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Siswa;
use App\Models\User;

class OrangTua extends Model
{
    use HasFactory;
    protected $table = 'orang_tuas';
    protected $fillable = [
        'nis',
        'nama',
        'pekerjaan',
        'no_hp',
        'alamat',
        'user_id',
    ];

    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'orang_tuas_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
