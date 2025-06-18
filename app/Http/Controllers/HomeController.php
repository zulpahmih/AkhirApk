<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\tata_tertib;
use App\Models\DataPointPelanggaran;

class HomeController extends Controller
{

    public function landingpage()
    {

        // Ambil hanya 5 data tata tertib terbaru (atau urutan awal)
        $tata = tata_tertib::oldest()->take(5)->get();
        $data = DataPointPelanggaran::oldest()->take(5)->get();  
        // $data = data_pelanggaran::oldest()->take(5)->get();

        return view('LandingPage', compact('tata','data'));
    }

     public function show_login()
    {
        return view('Login');
    }

    public function daftar()
    {
        return view('Daftar');
    }

    public function index_landing_tata()
    {
        $tata = tata_tertib::all();

        return view('TataTertib', compact('tata'));
    }

    public function index_landing_daftar_point()
    {
        $data = DataPointPelanggaran::all();

        return view('DaftarPointPelanggaran', compact('data'));
    }

    public function index_landing_profile()
    {

        return view('Profile');
    }
    
    
}
