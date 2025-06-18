<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrangTuaController extends Controller
{
    public function show_data_anak()
    {
        return view('OrangTua.DataPelanggaranAnak');
    }
}
