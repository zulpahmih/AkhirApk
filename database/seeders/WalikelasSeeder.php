<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WaliKelas;
use App\Models\Guru;
use App\Models\KelasJurusan;

class WalikelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gurus = Guru::all();
        $kelasJurusans = KelasJurusan::all();

        $total = min($gurus->count(), $kelasJurusans->count());

        for ($i = 0; $i < $total; $i++) {
        WaliKelas::create([
            'guru_id' => $gurus[$i]->id,
            'kelas_jurusan_id' => $kelasJurusans[$i]->id,
        ]);
        }
    }

}
