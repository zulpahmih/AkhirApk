<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function show_lihat_data_pelanggaran_kelas()
    {
        return view('Guru.LihatDataPelanggaranKelas');
    }

    public function show_kelola_data_pelanggaran_kelas()
    {
        return view('Guru.KelolaDataPelanggaranKelas');
    }

    //funtion untuk proses input data pelanggaran kelas
    
    public function create_data_pelanggaran_kelas()
    {
        return view('Guru.KelolaDataPelanggaranKelas');
    }
}
