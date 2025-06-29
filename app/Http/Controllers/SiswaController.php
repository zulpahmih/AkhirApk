<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;

class SiswaController extends Controller
{
    public function show_data_personal()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Ambil data siswa berdasarkan user login
        $siswa = Siswa::with([
            'kelasJurusan.kelas',
            'kelasJurusan.jurusan',
            'pelanggaransiswa',
            'orangtua',
        ])->where('user_id', $user->id)->firstOrFail();

        // Hitung total poin pelanggaran siswa
        $totalPoin = $siswa->pelanggaransiswa->sum(function ($pelanggaran) {
        return optional($pelanggaran->dataPointPelanggaran)->point_pelanggaran;
    });


        return view('Siswa.DataPersonal',compact('siswa', 'totalPoin'));
    }
    
}
