<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\jurusan;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jurusan = [
            'OTKP', 'TKRO', 'MESIN', 'LISTRIK',
            'DPIB', 'FARMASI', 'TKJ', 'PEMASARAN',
        ];

        foreach ($jurusan as $j) {
            Jurusan::create(['nama_jurusan' => $j]);
        }
    }
}
