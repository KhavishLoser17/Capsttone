<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IndexController extends Controller
{
    //
    public function dashboard(){

        return view('auth.others.dashboard');
    }
    public function employeedashboard(){

        return view('auth.others.employeedashboard');
    }

}
