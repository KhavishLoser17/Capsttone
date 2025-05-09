<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reflection;
use App\Models\VideoHR2;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class ReflectionController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'seminar_id' => 'required|exists:video_hr2s,id',
            'comment' => 'required|string',
            'document' => 'nullable|file|mimes:pdf,doc,docx,txt|max:10240',
        ]);

        $userId = Auth::id();
        $apiEmployeeId = null;

        $response = Http::get(env('EMPLOYEE_API_URL'));

        if ($response->successful()) {
            $employees = collect($response->json());

            $employee = $employees->first(function ($employee) use ($userId) {
                return
                    ($employee['id'] ?? null) == $userId ||
                    ($employee['user_id'] ?? null) == $userId;
            });

            if ($employee) {
                $apiEmployeeId = $employee['employeeId']
                              ?? $employee['employeeID']
                              ?? $employee['employee_id']
                              ?? $employee['emp_id']
                              ?? null;
            }
        }

        $reflection = new Reflection();

        $reflection->employee_id = $apiEmployeeId ?? 'UNKNOWN'; // avoid null in DB
        $reflection->seminar_id = $request->seminar_id;

        $reflection->comment = $apiEmployeeId
            ? "API_EMPLOYEE_ID: {$apiEmployeeId}\n\n" . $request->comment
            : $request->comment;

        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('reflection_documents', 'public');
            $reflection->document_path = $path;
        }

        $reflection->save();

        return redirect()->back()->with('toast', 'Submitted Successfully.');
    }
}
