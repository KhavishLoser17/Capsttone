<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\LearningContent;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Models\SurveyResponse;
use App\Models\Video;
use App\Models\WebContent;
use App\Models\Present;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\ExamResult;
use Illuminate\Support\Facades\Storage;
use App\Models\HasFactory;
use App\Models\Question;
use Illuminate\Support\Facades\Validator;
use App\Services\GeminiService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ContentController extends Controller
{

    protected $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }
    public function content(){
        return view('auth/others/content');
    }
    public function learn(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'explanation' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('learning-content', 'public');
        }

        LearningContent::create([
            'title' => $request->title,
            'explanation' => $request->explanation,
            'image_path' => $imagePath
        ]);

        return redirect()->back()->with('success', 'Content added successfully.');
    }
    public function webcontent(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url|max:500',
        ]);

        WebContent::create([
            'title' => $request->title,
            'url' => $request->url,
        ]);

        return redirect()->back()->with('success', 'Web Content published successfully.');
    }
    public function youtube(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'youtube_url' => [
                'nullable', // Make YouTube URL optional
                'url',
                function ($attribute, $value, $fail) {
                    // Only validate YouTube URL if it's provided
                    if ($value && !Video::extractYouTubeVideoId($value)) {
                        $fail('Invalid YouTube URL');
                    }
                }
            ],
            'video_file' => 'nullable|file|mimes:mp4,mov,avi,webm|max:51200'
        ], [
            'youtube_url.url' => 'Please enter a valid YouTube URL.'
        ]);

        // Check validation
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $videoPath = null;
            $normalizedUrl = null;

            // Handle video file upload
            if ($request->hasFile('video_file')) {
                $videoPath = $request->file('video_file')->store('videos', 'public');
            }

            // Handle YouTube URL
            if ($request->filled('youtube_url')) {
                $normalizedUrl = Video::normalizeYouTubeUrl($request->youtube_url);

                // Check if video already exists
                $existingVideo = Video::where('youtube_url', $normalizedUrl)->first();
                if ($existingVideo) {
                    return redirect()->back()->with('error', 'This YouTube video has already been added.');
                }
            }

            // Create new video entry
            $video = Video::create([
                'video_type' => $videoPath ? 'uploaded' : 'youtube',
                'youtube_url' => $normalizedUrl,
                'video_path' => $videoPath
            ]);

            return redirect()->back()->with('success', 'Video added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error adding video: ' . $e->getMessage());
        }
    }
    public function present(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|mimes:pdf,pptx,doc,docx|max:51200', // 50MB limit
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('presentations', 'public');
        }

        Present::create([
            'title' => $request->title,
            'file_path' => $filePath,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Presentation uploaded successfully!');
    }
    public function assignment(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'required|string',
            'due_date' => 'required|date',
        ]);

        Assignment::create([
            'title' => $request->title,
            'details' => $request->details,
            'due_date' => $request->due_date,
        ]);

        return response()->json(['message' => 'Assignment created successfully!']);
    }
    public function survey(Request $request)
    {
        // Validate form data
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'questions' => 'required|array|min:1',
            'questions.*' => 'required|string|max:255',
            'responses' => 'nullable|array',
            'responses.*' => 'nullable|in:happy,moderate,angry,sad'
        ]);

        try {
            // Create the survey record
            $survey = Survey::create([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'due_date' => $validatedData['due_date'],
            ]);

            // Store questions and responses
            foreach ($validatedData['questions'] as $index => $questionText) {
                $question = SurveyQuestion::create([
                    'survey_id' => $survey->id,
                    'question_text' => $questionText,
                ]);

                if (!empty($validatedData['responses'][$index])) {
                    SurveyResponse::create([
                        'survey_question_id' => $question->id,
                        'response_type' => $validatedData['responses'][$index],
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Survey created successfully!');
        } catch (\Exception $e) {
            Log::error('Survey creation error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while creatinssg the survey.');
        }
    }
    public function exam(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit' => 'required|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
            'questions' => 'required|array|min:1',
            'options' => 'required|array|min:1',
            'correct_answers' => 'required|array|min:1',
        ]);

        $exam = Exam::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'time_limit' => $validated['time_limit'],
            'passing_score' => $validated['passing_score'],
        ]);

        foreach ($validated['questions'] as $index => $questionText) {
            $options = explode(',', $validated['options'][$index]);
            $formattedOptions = [];

            // Format options with letter prefixes (A. B. C. D.)
            foreach ($options as $i => $option) {
                $letter = chr(65 + $i); // 65 is ASCII for 'A'
                $formattedOptions[] = "$letter. " . trim($option);
            }

            // Format correct answer with letter prefix
            $correctAnswer = trim($validated['correct_answers'][$index]);
            $correctAnswerIndex = array_search($correctAnswer, array_map('trim', $options));

            if ($correctAnswerIndex !== false) {
                $letter = chr(65 + $correctAnswerIndex);
                $correctAnswer = "$letter. $correctAnswer";
            }

            ExamQuestion::create([
                'exam_id' => $exam->id,
                'question_text' => $questionText,
                'options' => $formattedOptions,
                'correct_answer' => $correctAnswer,
            ]);
        }

        return redirect()->back()->with('success', 'Exam created successfully!');
    }
    public function generateAndStoreQuestions(Request $request)
{
    // Validate incoming request
    $validatedData = $request->validate([
        'topic' => 'required|string|max:100',
        'difficulty' => 'required|in:easy,medium,hard',
        'questionType' => 'required|in:multiple-choice,true-false,short-answer',
        'additionalContext' => 'nullable|string|max:500'
    ]);

    try {
        $questionsToGenerate = 5;
        $storedQuestions = [];

        for ($i = 0; $i < $questionsToGenerate; $i++) {
            // Generate question using Gemini Service
            $result = $this->geminiService->generateQuestion($validatedData);

            if (!$result['success']) {
                return redirect()->back()->with('error', $result['error']);
            }

            // Parse the generated question
            $parsedQuestion = $this->geminiService->parseGeneratedQuestion($result['question'], $validatedData);

            // Store the question in the database
            $question = Question::create([
                'topic' => $validatedData['topic'],
                'difficulty' => $validatedData['difficulty'],
                'type' => $validatedData['questionType'],
                'question_text' => $parsedQuestion['text'],
                'answer' => $parsedQuestion['answer'],
                'explanation' => $parsedQuestion['explanation'],
                'options' => $parsedQuestion['options'],
                'user_id' => Auth::id()
            ]);

            $storedQuestions[] = $question;
        }

        return redirect()->back()->with('success', count($storedQuestions) . ' questions generated and stored successfully.');

    } catch (\Exception $e) {
        Log::error('Question Generation Error: ' . $e->getMessage());

        return redirect()->back()->with('error', 'Failed to generate and store questions.');
    }
}
public function startExam(Request $request, $examId)
{
    $exam = Exam::with('questions')->findOrFail($examId);

    // Check if user has already taken this exam
    $existingResult = ExamResult::where('user_id', Auth::id())
                              ->where('exam_id', $examId)
                              ->first();

    if ($existingResult) {
        if ($request->ajax()) {
            return response()->json([
                'error' => 'You have already taken this exam.',
                'result' => $existingResult,
                'exam' => $exam
            ], 400);
        }
        return redirect()->back()->with('error', 'You have already taken this exam.');
    }

    // Store exam session in session with more data
    $request->session()->put('exam_in_progress', [
        'exam_id' => $examId,
        'start_time' => now(),
        'user_id' => Auth::id()
    ]);

    // If AJAX request, return JSON
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Exam started successfully',
            'exam' => [
                'id' => $exam->id,
                'title' => $exam->title,
                'description' => $exam->description,
                'time_limit' => $exam->time_limit,
                'passing_score' => $exam->passing_score,
                'questions_count' => $exam->questions->count()
            ]
        ]);
    }

    // For traditional form submission
    return view('exams.take', compact('exam'));
}


public function submitExam(Request $request)
{
    try {
        // Verify the exam is in progress
        $examSession = $request->session()->get('exam_in_progress');

        if (!$examSession) {
            return response()->json([
                'error' => 'No exam in progress. Please start the exam again.'
            ], 400);
        }

        $examId = $examSession['exam_id'];
        $userId = $examSession['user_id'];
        $startTime = $examSession['start_time'];

        $exam = Exam::with('questions')->findOrFail($examId);

        // Check if user has already taken this exam
        $existingResult = ExamResult::where('user_id', $userId)
                                    ->where('exam_id', $examId)
                                    ->first();

        if ($existingResult) {
            return response()->json([
                'error' => 'You have already taken this exam.',
                'result' => $existingResult,
                'exam' => $exam
            ], 400);
        }

        // Check if exam time has expired
        $timeLimit = $exam->time_limit * 60; // Convert to seconds
        $timeElapsed = now()->diffInSeconds($startTime);

        $forceSubmit = false;
        if ($timeElapsed > $timeLimit) {
            $forceSubmit = true;
        }

        $submittedAnswers = $request->input('answer', []);

        // Calculate the score
        $totalQuestions = $exam->questions->count();
        $correctAnswers = 0;
        $userAnswersData = [];

        foreach ($exam->questions as $question) {
            $questionId = $question->id;
            $userAnswer = $submittedAnswers[$questionId] ?? null;

            // Strip the letter prefix for comparison if it exists
            $userAnswerValue = $userAnswer;
            if ($userAnswer && preg_match('/^[A-D]\.\s(.+)$/', $userAnswer, $matches)) {
                $userAnswerValue = $matches[1];
            }

            // Compare with correct answer (which may or may not have a letter prefix)
            $correctAnswerValue = $question->correct_answer;
            if (preg_match('/^[A-D]\.\s(.+)$/', $correctAnswerValue, $matches)) {
                $correctAnswerValue = $matches[1];
            }

            $isCorrect = (trim($userAnswerValue) === trim($correctAnswerValue));

            if ($isCorrect) {
                $correctAnswers++;
            }

            // Store the detailed answer data
            $userAnswersData[$questionId] = [
                'question_text' => $question->question_text,
                'user_answer' => $userAnswer,
                'correct_answer' => $question->correct_answer,
                'is_correct' => $isCorrect
            ];
        }

        $percentage = ($totalQuestions > 0) ? ($correctAnswers / $totalQuestions) * 100 : 0;
        $passed = ($percentage >= $exam->passing_score);

        $result = ExamResult::create([
            'user_id' => $userId,
            'exam_id' => $examId,
            'score' => $correctAnswers,
            'percentage' => $percentage,
            'passed' => $passed,
            'answers' => $userAnswersData,
        ]);

        // Clear exam session
        $request->session()->forget('exam_in_progress');

        // Return JSON response with result data
        return response()->json([
            'success' => true,
            'exam' => [
                'id' => $exam->id,
                'title' => $exam->title,
                'description' => $exam->description,
                'passing_score' => $exam->passing_score,
            ],
            'result' => $result,
        ]);
    } catch (\Exception $e) {
        Log::error('Exam submission error: ' . $e->getMessage());
        return response()->json([
            'error' => 'An error occurred while submitting the exam: ' . $e->getMessage()
        ], 500);
    }
}
public function showResults($examId)
{
    $exam = Exam::findOrFail($examId);
    $result = ExamResult::where('user_id', Auth::id())
                    ->where('exam_id', $examId)
                    ->firstOrFail();

    return view('exams.results', compact('exam', 'result'));
}

        /**
         * Admin method to view all exam results
         */
        // public function adminResults()
        // {
        //     // Check if user is admin
        //     if (!Auth::user()->isAdmin()) {
        //         return redirect()->route('home')->with('error', 'Unauthorized access');
        //     }

        //     $results = ExamResult::with(['user', 'exam'])
        //                         ->orderBy('created_at', 'desc')
        //                         ->paginate(20);

        //     return view('admin.exam-results', compact('results'));
        // }

        // /**
        //  * Admin method to view detailed exam result
        //  */
        // public function adminViewResult($resultId)
        // {
        //     // Check if user is admin
        //     if (!Auth::user()->isAdmin()) {
        //         return redirect()->route('home')->with('error', 'Unauthorized access');
        //     }

        //     $result = ExamResult::with(['user', 'exam'])
        //                     ->findOrFail($resultId);

        //     return view('admin.exam-result-detail', compact('result'));
        // }



public function fetchPaginatedContent(Request $request)
{
    $assignments = Assignment::paginate(1);
    $learningContents = LearningContent::paginate(1);
    $surveys = Survey::paginate(1);
    $surveysQuestion = SurveyQuestion::paginate(5);
    $surveyResponse = SurveyResponse::paginate(5);
    $videos = Video::paginate(1);
    $quizzes = Question::paginate(5);
    $webContents = WebContent::paginate(1);

    // Eager load questions for exams
    $exams = Exam::with('questions')->paginate(1);
    $examQuestions = ExamQuestion::paginate(5);

    return view('auth.others.content', compact(
        'assignments', 'learningContents', 'surveys', 'surveysQuestion',
        'surveyResponse', 'quizzes', 'videos', 'webContents', 'exams', 'examQuestions'
    ));
}

}
