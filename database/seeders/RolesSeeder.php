<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\RolesModel as Roles;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Roles::create([
            'id' => 1,
            'nama_role' => 'guru_bk',
        ]);
        Roles::create([
            'id' => 2,
            'nama_role' => 'guru_wakel',
        ]);
        Roles::create([
            'id' => 3,
            'nama_role' => 'siswa',
        ]);
        Roles::create([
            'id' => 4,
            'nama_role' => 'ortu',
        ]); 
        Roles::create([
            'id' => 5,
            'nama_role' => 'kepsek',
        ]); 
        Roles::create([
            'id' => 6,
            'nama_role' => 'guru',
        ]);
    }
}
