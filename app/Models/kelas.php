<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';
    protected $fillable = ['kelas'];

    public function getNamaAttribute()
    {
        return $this->kelas;
    }
}
