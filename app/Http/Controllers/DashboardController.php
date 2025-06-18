<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function all_dashboard()
    {
        if (auth()->user()->roles_id == 1) {
            return view('Welcome');
        }
        elseif (auth()->user()->roles_id == 2) { 
            return view('Welcome');
        }
        elseif (auth()->user()->roles_id == 3) {
            return view('Welcome');
        }
        elseif (auth()->user()->roles_id == 4) {
            return view('Welcome');
        }
        elseif (auth()->user()->roles_id == 5) {
            return view('Welcome');
        }
    }

}
