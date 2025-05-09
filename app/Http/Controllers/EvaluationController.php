<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamResult;
use App\Models\Exam;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Reflection;
use App\Models\Evaluation;
use Illuminate\Support\Facades\Http;
use App\Models\VideoHR2;

class EvaluationController extends Controller
{
    public function evaluation()
    {
        $results = ExamResult::with(['user', 'exam.questions'])
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('auth.others.evaluation', compact('results'));
    }
    public function index()
    {
        // Get the authenticated user's exam results
        $examResults = ExamResult::with('exam')
                        ->where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('auth.others.evaluation', compact('examResults'));
    }


    public function competent()
    {
        // Fetch employee data from API
        $response = Http::get(env('EMPLOYEE_API_URL'));

        if ($response->failed()) {
            abort(500, 'Failed to fetch employee data');
        }

        $employees = collect($response->json());

        // Get all exam results
        $examResults = ExamResult::with('exam')->get();

        // Count passed and failed
        $passedCount = $examResults->where('passed', true)->count();
        $failedCount = $examResults->where('passed', false)->count();

        // Exam statistics
        $examStats = Exam::select('exams.id', 'exams.title')
            ->selectRaw('COUNT(DISTINCT exam_results.user_id) as attempt_count')
            ->selectRaw('SUM(CASE WHEN exam_results.passed = 1 THEN 1 ELSE 0 END) as passed_count')
            ->selectRaw('ROUND(AVG(exam_results.percentage), 2) as avg_score')
            ->leftJoin('exam_results', 'exams.id', '=', 'exam_results.exam_id')
            ->groupBy('exams.id', 'exams.title')
            ->get();

        // Create a lookup array for employee IDs
        $employeeIdMap = [];
        foreach ($employees as $employee) {
            $id = $employee['id'] ?? null;
            $employeeId = $employee['employeeId'] ?? null;

            if ($id) {
                $employeeIdMap[$id] = $employeeId;
            }
        }

        // Custom user stats based on API and exam results
        $userStats = $employees->map(function ($employee) use ($examResults, $employeeIdMap) {
            $employeeId = $employee['employeeId'] ?? $employee['id'] ?? null;

            // Find exam results for this employee by looking up various possible ID matches
            $userExamResults = $examResults->filter(function($result) use ($employee, $employeeId, $employeeIdMap) {
                $userId = $result->user_id;

                // Check direct match
                if ($userId == $employeeId) {
                    return true;
                }

                // Check if user_id maps to an employeeId
                if (isset($employeeIdMap[$userId]) && $employeeIdMap[$userId] == $employeeId) {
                    return true;
                }

                return false;
            });

            $examsTaken = $userExamResults->count();
            $examsPassed = $userExamResults->where('passed', 1)->count();
            $avgScore = $examsTaken > 0 ? round($userExamResults->avg('percentage'), 2) : 0;

            return [
                'employeeId' => $employeeId ?? 'EMP-' . rand(1000, 9999), // Ensure we always have an employeeId
                'first_name' => $employee['first_name'] ?? $employee['name'] ?? 'Unknown',
                'image_url' => $employee['image_url'] ?? null,
                'exams_taken' => $examsTaken,
                'exams_passed' => $examsPassed,
                'avg_score' => $avgScore,
            ];
        });

        $examNames = $examStats->pluck('title')->toArray();
        $examScores = $examStats->pluck('avg_score')->toArray();

        // Add scripts needed for Excel export
        $scripts = [
            'https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js'
        ];

        return view('auth.others.competent', compact(
            'examResults',
            'passedCount',
            'failedCount',
            'examStats',
            'userStats',
            'examNames',
            'examScores',
            'scripts'
        ));
    }

    public function competentApi()
    {
        // Step 1: Fetch employee details from external API
        $response = Http::get(env('EMPLOYEE_API_URL'));

        if (!$response->successful()) {
            return response()->json([
                'error' => 'Failed to fetch employee details from external API.',
            ], 500);
        }

        $employees = collect($response->json());

        // Step 2: Index employees by ID for quick access
        $employeesById = $employees->keyBy(function ($employee) {
            // Try multiple potential ID fields that might be in your API response
            return $employee['id'] ?? $employee['user_id'] ?? $employee['employeeId'] ?? $employee['employeeID'];
        });

        // Step 3: Get exam results with only exam relationship (no user model)
        $examResults = ExamResult::with('exam:id,title')
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($result) use ($employeesById) {
            // Find the employee record that matches this user_id
            $employee = $employeesById->get($result->user_id);

            // If employee is not found, use user_id as employee_id
            $employeeId = $employee['employeeId']
                        ?? $employee['employeeID']
                        ?? $employee['employee_id']
                        ?? $employee['emp_id']
                        ?? $result->user_id; // Fallback to user_id

            return [
                'user' => [
                    'id' => $result->user_id,
                    'employee_id' => $employeeId, // This will never be null
                    'name' => ($employee['first_name'] ?? '') . ' ' . ($employee['last_name'] ?? ''),
                    'department' => $employee['department'] ?? null,
                    'position' => $employee['position'] ?? null,
                ],
                'exam' => [
                    'id' => $result->exam->id ?? null,
                    'title' => $result->exam->title ?? null,
                ],
                'percentage' => $result->percentage,
                'passed' => $result->passed,
                'created_at' => $result->created_at->toDateTimeString(),
            ];
        });

        // Step 4: Summary stats
        $passedCount = $examResults->where('passed', true)->count();
        $failedCount = $examResults->where('passed', false)->count();

        // Step 5: Exam-level stats
        $examStats = Exam::select('exams.id', 'exams.title')
            ->selectRaw('COUNT(DISTINCT exam_results.user_id) as attempt_count')
            ->selectRaw('SUM(CASE WHEN exam_results.passed = 1 THEN 1 ELSE 0 END) as passed_count')
            ->selectRaw('ROUND(AVG(exam_results.percentage), 2) as avg_score')
            ->leftJoin('exam_results', 'exams.id', '=', 'exam_results.exam_id')
            ->groupBy('exams.id', 'exams.title')
            ->get();

        // Step 6: User-level stats built from in-memory data
        $userStats = $examResults->groupBy(fn($item) => $item['user']['id'])
        ->map(function ($group) {
            $first = $group->first();
            return [
                'id' => $first['user']['id'],
                'employee_id' => $first['user']['employee_id'], // This will never be null now
                'name' => $first['user']['name'],
                'department' => $first['user']['department'],
                'position' => $first['user']['position'],
                'exams_taken' => $group->count(),
                'exams_passed' => $group->where('passed', true)->count(),
                'avg_score' => round($group->avg('percentage'), 2),
            ];
        })
        ->values();

        // Step 7: Chart data
        $chartData = [
            'exam_names' => $examStats->pluck('title'),
            'avg_scores' => $examStats->pluck('avg_score'),
        ];

        // Final response
        return response()->json([
            'summary' => [
                'passed_count' => $passedCount,
                'failed_count' => $failedCount,
            ],
            'exam_results' => $examResults,
            'exam_statistics' => $examStats,
            'user_statistics' => $userStats,
            'chart_data' => $chartData,
        ]);
    }



    public function getExamResultById($id)
    {
        $result = ExamResult::with(['user:id,first_name,last_name', 'exam:id,title'])->findOrFail($id);

        return response()->json([
            'id' => $result->id,
            'user' => [
                'id' => $result->user->id,
                'name' => $result->user->first_name . ' ' . $result->user->last_name,
            ],
            'exam' => [
                'id' => $result->exam->id,
                'title' => $result->exam->title,
            ],
            'percentage' => $result->percentage,
            'passed' => $result->passed,
            'created_at' => $result->created_at->toDateTimeString(),
        ]);
    }


private function calculateCompetencyLevel($results)
{
    if ($results->isEmpty()) {
        return 'Not Assessed';
    }

    $avgScore = $results->avg('percentage');

    if ($avgScore >= 90) {
        return 'Expert';
    } elseif ($avgScore >= 80) {
        return 'Advanced';
    } elseif ($avgScore >= 70) {
        return 'Proficient';
    } elseif ($avgScore >= 60) {
        return 'Basic';
    } else {
        return 'Novice';
    }
}

/**
 * Identify user's strengths based on exam results
 */
private function identifyStrengths($results)
{
    $strengths = [];

    foreach ($results as $result) {
        if ($result->percentage >= 80) {
            $strengths[] = [
                'exam' => $result->exam->title,
                'score' => $result->percentage,
                'date' => $result->created_at->format('M d, Y')
            ];
        }
    }

    return $strengths;
}

/**
 * Identify user's weaknesses based on exam results
 */
private function identifyWeaknesses($results)
{
    $weaknesses = [];

    foreach ($results as $result) {
        if ($result->percentage < 70) {
            $weaknesses[] = [
                'exam' => $result->exam->title,
                'score' => $result->percentage,
                'date' => $result->created_at->format('M d, Y')
            ];
        }
    }

    return $weaknesses;
}
    // public function reflection(){
    //     return view('auth.others.reflection');
    // }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'reflection_id' => 'required|exists:reflections,id',
            'evaluation_score' => 'required|integer|min:1|max:5',
            'evaluation_type' => 'required|string',
            'evaluation_comments' => 'required|string'
        ]);

        try {
            // Get the reflection
            $reflection = Reflection::findOrFail($request->reflection_id);

            // Create the evaluation
            $evaluation = new Evaluation();
            $evaluation->reflection_id = $reflection->id;
            $evaluation->evaluator_id = Auth::id(); // Current admin
            $evaluation->evaluation_score = $request->evaluation_score;
            $evaluation->evaluation_type = $request->evaluation_type;
            $evaluation->evaluation_comments = $request->evaluation_comments;
            $evaluation->evaluated_at = Carbon::now();
            $evaluation->save();

            // Mark the reflection as evaluated
            $reflection->is_evaluated = true;
            $reflection->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    // public function getEvaluationDetails($id)
    // {
    //     $reflection = Reflection::with([
    //         'employee',
    //         'seminar',
    //         'evaluation',
    //         'evaluation.evaluator'
    //     ])->findOrFail($id);

    //     if (!$reflection->is_evaluated) {
    //         return response()->json(['error' => 'This reflection has not been evaluated yet.'], 404);
    //     }

    //     return response()->json([
    //         'reflection' => $reflection,
    //         'employee' => $reflection->employee,
    //         'seminar' => $reflection->seminar,
    //         'evaluation' => $reflection->evaluation,
    //         'evaluator' => $reflection->evaluation->evaluator
    //     ]);
    // }
    public function reflection()
    {
        $pendingReflections = Reflection::where('is_evaluated', false)
            ->orderBy('created_at', 'desc')
            ->with(['seminar'])
            ->get();

        $completedReflections = Reflection::where('is_evaluated', true)
            ->orderBy('created_at', 'desc')
            ->with(['seminar', 'evaluation.evaluator'])
            ->get();

        // Fetch employee data from external API with error handling
        try {
            $response = Http::get(env('EMPLOYEE_API_URL'));
            $employeesApi = $response->successful() ? collect($response->json()) : collect([]);
        } catch (\Exception $e) {
            $employeesApi = collect([]);
        }

        $defaultEmployee = [
            'employee_id' => 'EMP-76492',
            'first_name' => 'James',
            'last_name' => 'Branso',
            'email' => 'james@gmail.com'
        ];

        // Helper function
        $attachEmployeeData = function ($reflection) use ($employeesApi, $defaultEmployee) {
            if (!$reflection->seminar) {
                $reflection->seminar = (object)[
                    'title' => 'Unknown Training',
                    'date_time' => now()
                ];
            }

            // Find matching employee data
            $employee = $employeesApi->first(function ($emp) use ($reflection) {
                $empId = $emp['employee_id'] ?? $emp['employeeId'] ?? $emp['emp_id'] ?? null;
                return $empId == $reflection->employee_id;
            });

            // Attach employee data
            if ($employee) {
                $reflection->employee_data = [
                    'employee_id' => $employee['employee_id'] ?? $employee['employeeId'] ?? $employee['emp_id'] ?? 'EMP-76492',
                    'first_name' => $employee['first_name'] ?? 'James',
                    'last_name' => $employee['last_name'] ?? 'Branso',
                    'email' => $employee['email'] ?? 'james@gmail.com'
                ];
            } else {
                $reflection->employee_data = $defaultEmployee;
            }

            return $reflection;
        };

        $pendingReflections = $pendingReflections->map($attachEmployeeData);
        $completedReflections = $completedReflections->map($attachEmployeeData);

        return view('auth.others.reflection', compact('pendingReflections', 'completedReflections'));
    }

    public function getReflection($id)
    {
        $reflection = Reflection::with(['seminar'])->findOrFail($id);

        // Get external employee API
        $employeesApi = collect();
        $response = Http::get(env('EMPLOYEE_API_URL'));
        if ($response->successful()) {
            $employeesApi = collect($response->json());
        }

        // Try to find matching employee
        $employee = $employeesApi->first(function ($emp) use ($reflection) {
            return
                ($emp['employee_id'] ?? null) === $reflection->employee_id ||
                ($emp['employeeId'] ?? null) === $reflection->employee_id ||
                ($emp['emp_id'] ?? null) === $reflection->employee_id;
        });

        // Fallback if not found
        $employeeData = [
            'employee_id' => $employee['employee_id'] ?? 'EMP-76492',
            'first_name' => $employee['first_name'] ?? 'James',
            'last_name' => $employee['last_name'] ?? 'Branso',
            'email' => $employee['email'] ?? 'james@gmail.com',
        ];

        // Clean comment
        $comment = preg_replace('/API_EMPLOYEE_ID:\s*[\w-]+\s*/i', '', $reflection->comment);

        return response()->json([
            'employee' => $employeeData,
            'seminar' => [
                'id' => $reflection->seminar->id,
                'title' => $reflection->seminar->title ?? 'Training Session ' . $reflection->seminar->id
            ],
            'comment' => trim($comment),
            'document_path' => $reflection->document_path
        ]);
    }


    public function getEvaluation($id)
{
    $reflection = Reflection::with(['seminar', 'evaluation.evaluator'])->findOrFail($id);

    // Fetch external employee API
    $employeesApi = collect();
    $response = Http::get(env('EMPLOYEE_API_URL'));
    if ($response->successful()) {
        $employeesApi = collect($response->json());
    }

    // Find matching employee by employee_id
    $employee = $employeesApi->first(function ($emp) use ($reflection) {
        return
            ($emp['employee_id'] ?? null) === $reflection->employee_id ||
            ($emp['employeeId'] ?? null) === $reflection->employee_id ||
            ($emp['emp_id'] ?? null) === $reflection->employee_id;
    });

    // Remove "API_EMPLOYEE_ID:" from comment
    $cleanComment = preg_replace('/API_EMPLOYEE_ID:\s*[\w-]+\s*/i', '', $reflection->comment);

    return response()->json([
        'reflection' => [
            'employee' => [
                'first_name' => $employee['first_name'] ?? 'Unknown',
                'last_name' => $employee['last_name'] ?? 'User',
                'email' => $employee['email'] ?? '',
            ],
            'seminar' => $reflection->seminar,
            'comment' => trim($cleanComment),
        ],
        'evaluation' => $reflection->evaluation,
        'evaluator' => $reflection->evaluation->evaluator ?? null
    ]);
}

public function get_evaluation()
{
    $evaluations = Evaluation::with(['reflection.seminar'])->get();

    $response = Http::get(env('EMPLOYEE_API_URL'));
    $employees = $response->successful() ? collect($response->json()) : collect();

    $data = $evaluations->map(function ($evaluation) use ($employees) {
        $employeeId = $evaluation->reflection->employee_id ?? null;

        $employee = $employees->first(function ($emp) use ($employeeId) {
            return ($emp['employee_id'] ?? $emp['employeeId'] ?? $emp['emp_id'] ?? null) == $employeeId;
        });

        return [
            'reflection' => [
                'employee' => [
                    'employee_id' => $employee['employeeId'] ?? $employee['employee_id'] ?? $employee['emp_id'] ?? 'EMP-76492',
                    'first_name' => $employee['first_name'] ?? 'James',
                    'last_name' => $employee['last_name'] ?? 'Branso',
                ],
                'seminar' => [
                    'title' => $evaluation->reflection->seminar->title ?? null,
                ],
            ],
            'evaluation_score' => $evaluation->evaluation_score,
            'evaluation_type' => $evaluation->evaluation_type,
            'evaluation_comments' => $evaluation->evaluation_comments,
            'evaluated_at' => $evaluation->evaluated_at,
        ];
    });

    return response()->json($data);
}

public function get_evaluation_id($id)
{
    $evaluation = Evaluation::with(['reflection.seminar'])->findOrFail($id);

    $employeeId = $evaluation->reflection->employee_id ?? null;

    $response = Http::get(env('EMPLOYEE_API_URL'));
    $employees = $response->successful() ? collect($response->json()) : collect();

    $employee = $employees->first(function ($emp) use ($employeeId) {
        return ($emp['employee_id'] ?? $emp['employeeId'] ?? $emp['emp_id'] ?? null) == $employeeId;
    });

    $data = [
        'reflection' => [
            'employee' => [
                'employee_id' => $employee['employeeId'] ?? $employee['employee_id'] ?? $employee['emp_id'] ?? 'EMP-76492',
                'first_name' => $employee['first_name'] ?? 'James',
                'last_name' => $employee['last_name'] ?? 'Branso',
            ],
            'seminar' => [
                'title' => $evaluation->reflection->seminar->title ?? null,
            ],
        ],
        'evaluation_score' => $evaluation->evaluation_score,
        'evaluation_type' => $evaluation->evaluation_type,
        'evaluation_comments' => $evaluation->evaluation_comments,
        'evaluated_at' => $evaluation->evaluated_at,
    ];

    return response()->json($data);
}

        public function submit(Request $request)
        {
            $validated = $request->validate([
                'reflection_id' => 'required|exists:reflections,id',
                'evaluation_score' => 'required|integer|min:1|max:5',
                'evaluation_type' => 'required|string',
                'evaluation_comments' => 'required|string',

            ]);

            $reflection = Reflection::findOrFail($request->reflection_id);
            $reflection->evaluation_score = $request->evaluation_score;
            $reflection->evaluation_type = $request->evaluation_type;
            $reflection->evaluation_comments = $request->evaluation_comments;
            $reflection->evaluated_at = now();
            $reflection->evaluator_id = Auth::id();
            $reflection->save();

            return response()->json(['success' => true]);
        }
}
