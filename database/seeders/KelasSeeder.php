<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\kelas;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kelas::create(['kelas' => 'X']);
        Kelas::create(['kelas' => 'XI']);
        Kelas::create(['kelas' => 'XII']);
    }
}
