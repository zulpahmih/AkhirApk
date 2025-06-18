<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\kelas;
use App\Models\jurusan;
use App\Models\KelasJurusan;


class KelasJurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelas_list = Kelas::pluck('id', 'kelas');       // ['X' => 1, 'XI' => 2, ...]
        $jurusan_list = Jurusan::pluck('id', 'nama_jurusan'); // ['TKRO' => 1, 'TKJ' => 2, ...]

        foreach ($jurusan_list as $jurusan_nama => $jurusan_id) {
            foreach ($kelas_list as $kelas_nama => $kelas_id) {
                KelasJurusan::create([
                    'kelas_id'   => $kelas_id,
                    'jurusan_id' => $jurusan_id,
                ]);
            }
        }
    }
}
