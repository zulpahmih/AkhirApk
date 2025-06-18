<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\data_point_pelanggaran;

class tata_tertib extends Model
{
    use HasFactory;
    protected $table = 'tata_tertibs';
    protected $fillable = [
        'id',
        'nama_tata_tertib',
    ];

    public function pelanggarans()
    {
        return $this->hasMany(DataPointPelanggaran::class);
    }

}
