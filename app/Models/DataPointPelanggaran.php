<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tata_tertib;

class DataPointPelanggaran extends Model
{
    use HasFactory;

    protected $table = 'data_point_pelanggarans';

    protected $fillable = ['tata_tertib_id', 'nama_pelanggaran', 'point_pelanggaran'];

    public function tataTertib()
    {
        return $this->belongsTo(tata_tertib::class);
    }
    
}
