<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function show_data_personal()
    {
        return view('Siswa.DataPersonal');
    }
    
}
