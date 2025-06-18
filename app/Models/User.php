<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\RolesModel;
use App\Models\guru;
use App\Models\siswa;
use App\Models\OrangTua;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'users';
    protected $fillable = [
        'username',
        'password',
        'roles_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime'
    ];


    public function role()
    {
        return $this->belongsTo(RolesModel::class, 'roles_id');
    }

    public function guru()
    {
        return $this->belongsTo(guru::class, 'username','nip');
    }

    public function siswa()
    {
        return $this->belongsTo(siswa::class,'username','nis');
    }

    public function orangTua()
    {
       return $this->hasOne(OrangTua::class, 'user_id' );
    }

    public function getNamaAttribute()
    {
        // Jika user adalah guru dan relasi guru ada
        if ($this->guru) {
            return $this->guru->nama;
        }
        
        // Jika user adalah siswa dan relasi siswa ada
        if ($this->siswa) {
            return $this->siswa->nama;
        }

        // Jika user adalah orang tua dan relasi orangTua ada
        if ($this->orangTua) {
            return $this->orangTua->nama;

        // Jika tidak ada, fallback ke username saja
        return $this->username;

        }
    }

        public function getNamaFormattedAttribute()
    {
        return Str::title($this->nama);
    }

    public function getRoleFormattedAttribute()
    {
        return Str::title(optional($this->role)->nama_role);
    }

}   
   


