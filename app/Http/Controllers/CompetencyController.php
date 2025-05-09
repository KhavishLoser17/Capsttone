<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class CompetencyController extends Controller
{
    // public function competency(){
    //     $apiResponse = Http::get('http://192.168.1.22:8005/api/v3/employees');

    //     if ($apiResponse->successful()) {
    //         $employees = $apiResponse->json();
    //     } else {
    //         $employees = [];
    //     }
    //     return view('auth.others.competency', compact('employees'));
    // }
    public function competency()
    {
        $apiResponse = Http::get('https://hr4.easetravelandtours.com/api/get-employees-details');

        if ($apiResponse->successful()) {
            $employees = collect($apiResponse->json())->map(function ($employee) {
                // Add the employee name
                $employee['employee_name'] = ($employee['first_name'] ?? '') . ' ' . ($employee['last_name'] ?? '');
                $employeeId = $employee['id'] ?? 0;

                // Set seed based on employee ID for consistent random values
                srand(crc32($employeeId));

                // Generate skill scores between 40-75% for consistency
                $employee['technical_skill'] = 40 + (abs(crc32($employeeId . 'tech')) % 36);
                $employee['safety_skill'] = 40 + (abs(crc32($employeeId . 'safety')) % 36);
                $employee['leadership_skill'] = 40 + (abs(crc32($employeeId . 'leadership')) % 36);

                // Calculate overall score
                $employee['overall_score'] = round(($employee['technical_skill'] + $employee['safety_skill'] + $employee['leadership_skill']) / 3);

                // Reset random seed
                srand();

                return $employee;
            })->toArray();
        } else {
            $employees = [];
        }

        return view('auth.others.competency', compact('employees'));
    }

}
