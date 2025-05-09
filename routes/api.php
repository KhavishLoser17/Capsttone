<?php

use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\SeminarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Models\ExamResult;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->middleware('throttle:custom-throttle')->group(function (){
    Route::get('/seminar-schedule/get', [SeminarController::class, 'training_fetch_api']);
    Route::get('/seminar-schedule/get/{id}', [SeminarController::class, 'training_fetch_api_id']);

    Route::get('/get-evaluation', [EvaluationController::class, 'get_evaluation']);
    Route::get('/get-evaluation/{id}', [EvaluationController::class, 'get_evaluation_id']);

    Route::post('/evaluations/submit', [EvaluationController::class, 'submit']);

    Route::get('/get-competent', [EvaluationController::class, 'competentApi']);
    Route::get('/get-competent/{id}', [EvaluationController::class, 'getExamResultById']);
});


Route::get('/reflections/{id}', 'App\Http\Controllers\EvaluationController@getReflection');
Route::get('/evaluations/{id}', 'App\Http\Controllers\EvaluationController@getEvaluation');


Route::get('/employee-competency-ai/{id}', function($id) {
    $apiResponse = Http::get('https://hr4.easetravelandtours.com/api/get-employees-details');

    if (!$apiResponse->successful()) {
        return response()->json([]);
    }

    $employees = collect($apiResponse->json());
    $employee = $employees->firstWhere('id', $id);

    if (!$employee) {
        return response()->json([]);
    }

    $employee['employee_name'] = ($employee['first_name'] ?? '') . ' ' . ($employee['last_name'] ?? '');

    srand(crc32($employee['id'] ?? 0));
    $employee['technical_skill'] = 40 + (abs(crc32(($employee['id'] ?? 0) . 'tech')) % 36);
    $employee['safety_skill'] = 40 + (abs(crc32(($employee['id'] ?? 0) . 'safety')) % 36);
    $employee['leadership_skill'] = 40 + (abs(crc32(($employee['id'] ?? 0) . 'leadership')) % 36);
    srand();

    $currentDate = now()->format('Y-m-d');

    $prompt = "You are an AI expert in HR and competency management. Analyze the following employee data:
    - Name: {$employee['employee_name']}
    - Department: {$employee['department']}
    - Technical Skill: {$employee['technical_skill']}%
    - Safety Skill: {$employee['safety_skill']}%
    - Leadership Skill: {$employee['leadership_skill']}%
    Date: {$currentDate}.
    
    Provide a very **short AI insight** (maximum 2 sentences).
    
    For the Recommendation:
    - List **exactly 3 action points**.
    - Format them using bullet points (•) each on a new line.
    
    Return this JSON format:
    [{Employee:{String}, Department:{String}, CompetencyLevel:{String}, Insight:{String}, Recommendation:{String}}].
    
    
    Make the recommendation direct, simple, and actionable. No paragraphs, just clean numbering.";

    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . env('GEMINI_API_KEY');

    $response = Http::post($url, [
        'contents' => [
            ['parts' => [['text' => $prompt]]]
        ],
        'generationConfig' => [
            'responseMimeType' => 'application/json'
        ]
    ]);

    $textResult = $response->json()['candidates'][0]['content']['parts'][0]['text'];

    // THIS IS THE IMPORTANT PART:
    try {
        $parsedResult = json_decode($textResult, true);
    } catch (\Exception $e) {
        return response()->json([], 500); // Return empty if parsing failed
    }

    return response()->json($parsedResult);
});

Route::post('/employee-competency-ai/save-recommendation', function () {
    $id = request('id');
    $recommendation = request('recommendation');

    $employee = ExamResult::find($id);
    if (!$employee) return response()->json(['error' => 'Employee not found'], 404);

    $employee->recommendation = $recommendation; // Make sure you have a `recommendation` field!
    $employee->save();
    return response()->json(['code' => 200, 'content' => 'Recommendation saved!']);
});
