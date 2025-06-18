<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserSeeder extends Seeder
{
        public function run()
    { 
        // Guru BK
        User::create([
            'username' => 'gurubk',
            'password' => Hash::make('123'), // default password
            'roles_id' => 1,
        ]);

        // // Guru
        // User::create([
        //     'username' => 'guruwakel',
        //     'password' => Hash::make('123'),
        //     'roles_id' => 2,
        // ]);

        // // Siswa
        // User::create([
        //     'username' => 'siswa',
        //     'password' => Hash::make('123'),
        //     'roles_id' => 3,
        // ]);

        // // Orang Tua
        // User::create([
        //     'username' => 'ortu',
        //     'password' => Hash::make('123'), // default password
        //     'roles_id' => 4,
        // ]);
        
        // Kepala Sekolah
        User::create([
            'username' => 'kepsek',
            'password' => Hash::make('123'), // default password
            'roles_id' => 5,
        ]);
    }
    
}

