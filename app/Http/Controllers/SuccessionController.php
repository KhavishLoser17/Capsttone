<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class SuccessionController extends Controller
{
    public function succession()
    {
        $response = Http::get(env('EMPLOYEE_API_URL'));

        if ($response->successful()) {
            $employees = $response->json(); 
        } else {
            $employees = []; 
        }

        return view('auth.others.succession', compact('employees'));
    }
}
