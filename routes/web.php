<?php
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CompetencyController;
use App\Http\Controllers\SuccessionController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\SeminarController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\ReflectionController;
// use App\Http\Controllers\TwoFactorController;
// use App\Http\Middleware\Verify2FAMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;




// Route::middleware(['auth',Verify2FAMiddleware::class])->group(function(){
//     Route::get('/two-factor', [TwoFactorController::class, 'index'])->name('two-factor.index');
//     Route::post('/two-factor', [TwoFactorController::class, 'verify'])->name('two-factor.verify');
// });
Route::get('/login', [ClientController::class, 'login'])->name('login');
Route::post('/login', [ClientController::class, 'loginPost'])->name('loginPost');

Route::middleware(['auth.user','prevent.back','twofactor'])->group(function () {

    Route::get('/dashboard', [IndexController::class, 'dashboard'])->name('dashboard');
    Route::get('/employeedashboard', [IndexController::class, 'employeedashboard'])->name('employeedashboard');

    //COMPETENCY ROUTE
    Route::get('/competency', [CompetencyController::class, 'competency'])->name('competency');

    // Route::get('/api/employees/{id}', function ($id) {
    //     $apiResponse = Http::get("http://192.168.1.22:8005/api/v1/employees/{$id}");

    //     if ($apiResponse->successful()) {
    //         $data = $apiResponse->json();
    //         return response()->json($data);
    //     } else {
    //         return response()->json(['error' => 'Employee not found', 'response' => $apiResponse->body()], 404);
    //     }
    // });


    //FOR SUCCESSION ROUTE
    Route::get('/succession', [SuccessionController::class, 'succession'])->name('succession');

    //FOr LMS ROUTE
    Route::get('/learning', [LearningController::class, 'lms'])->name('learning');
    Route::get('/learning-employee', [LearningController::class, 'lmsemp'])->name('learning-employee');
    Route::get('/learning_add', [LearningController::class, 'addlms'])->name('learning_add');
    Route::post('register-training-api', [LearningController::class, 'storeTraining'])->name('add-learning');
    Route::get('/learning_add', [LearningController::class, 'show'])->name('learning.show');
    Route::get('/learning/{id}/edit', [LearningController::class, 'edit']);
    Route::put('/learning/{id}/update', [LearningController::class, 'update']);
    Route::delete('/learning/{id}', [LearningController::class, 'delete']);
    Route::get('/learning', [LearningController::class, 'index'])->name('learning');
    Route::get('/learning-employee', [LearningController::class, 'employee'])->name('learning-employee');



    //FOR TRAINING ROUTE
    Route::get('/training', [TrainingController::class, 'tms'])->name('training');
    Route::get('/training_add', [TrainingController::class, 'addtms'])->name('training_add');
    Route::post('register-video-api', [TrainingController::class, 'registerVideo'])->name('register-video-api');
    Route::get('/training_add', [TrainingController::class, 'show'])->name('training.list');
    Route::get('/training/{id}/edit', [TrainingController::class, 'edit'])->name('training.edit');
    Route::post('/training/{id}', [TrainingController::class, 'update'])->name('training.update');
    Route::delete('/training/{id}', [TrainingController::class, 'destroy'])->name('training.destroy');
    Route::get('/training', [TrainingController::class, 'index'])->name('training');



    //CONTENT
    Route::get('/content', [ContentController::class, 'content'])->name('content');
    Route::post('/content/store', [ContentController::class, 'learn'])->name('content.learn');
    Route::post('/web-content/store', [ContentController::class, 'webcontent'])->name('web-content.store');
    Route::post('/videos/store', [ContentController::class, 'youtube'])->name('videos.youtube');
    Route::post('/presentations/store', [ContentController::class, 'present'])->name('presentations.store');
    Route::post('/assignments/store', [ContentController::class, 'assignment'])->name('assignments.store');
    Route::post('/surveys/store', [ContentController::class, 'survey'])->name('surveys.store');

    Route::post('/exams/store', [ContentController::class, 'exam'])->name('exams.store');
    Route::post('/exams/submit', 'App\Http\Controllers\ContentController@submitExam')->name('exams.submit');
    Route::post('/exams/start/{examId}', [ContentController::class, 'startExam'])->name('exams.start');


    Route::post('/generate-and-store-question', [ContentController::class, 'generateAndStoreQuestions'])->name('questions.generate');
    Route::get('/content/fetch', [ContentController::class, 'fetchPaginatedContent'])->name('content.fetch');

    Route::post('/send-email', [MailController::class, 'sendEmail']);
    Route::post('/send-congratulatory-email', [MailController::class, 'sendCongratulatoryEmail']);

    Route::get('/seminar', [SeminarController::class, 'seminar'])->name('auth.others.seminar');
    Route::post('/seminar/store', [SeminarController::class, 'store'])->name('seminar.store');
    Route::get('/api/trainings', [SeminarController::class, 'getTrainings'])->name('api.trainings');
    Route::get('/training-schedule/{id}/edit', [SeminarController::class, 'edit'])->name('training.schedule.edit');
    Route::put('/training-schedule/{id}', [SeminarController::class, 'update'])->name('training.schedule.update');
    Route::delete('/trainings/{id}', [SeminarController::class, 'destroy'])->name('trainings.destroy');


    Route::get('/evaluation', [EvaluationController::class, 'evaluation'])->name('auth.others.evaluation');
    Route::get('/competent',  [EvaluationController::class, 'competent'])->name('competent');
    Route::get('reflection', [EvaluationController::class, 'reflection'])->name('reflection');
    Route::post('/auth/others/reflection/evaluate', [EvaluationController::class, 'store'])->name('reflection.evaluate');

    // Archive routes
    Route::get('/archive', [ArchiveController::class, 'archive'])->name('auth.others.archive');
    // Route::get('/archives', [ArchiveController::class, 'index'])->name('archives.index');
    Route::post('/restore-schedule/{id}', [ArchiveController::class, 'restoreSchedule'])->name('restore-schedule');
    Route::post('/restore-hr2/{id}', [ArchiveController::class, 'restoreHR2'])->name('restore-hr2');
    Route::delete('/destroy-schedule-permanent/{id}', [ArchiveController::class, 'destroySchedulePermanent'])->name('destroy-schedule-permanent');
    Route::delete('/destroy-hr2-permanent/{id}', [ArchiveController::class, 'destroyHR2Permanent'])->name('destroy-hr2-permanent');
    Route::post('/restore-video-hr2/{id}', [ArchiveController::class, 'restoreVideoHR2'])->name('restore.video-hr2');
    Route::delete('/destroy-video-hr2-permanent/{id}', [ArchiveController::class, 'destroyVideoHR2Permanent'])->name('destroy.video-hr2.permanent');

    });

    // Route::post('/reflection/submit', [ReflectionController::class, 'submit'])->name('reflection.submit');
    //     Route::get('/callback', function (Request $request) {
    //         $token = $request->query('token');

    //         if (!$token) {
    //             return abort(403, 'Missing token.');
    //         }

    //         try {
    //             $response = Http::withToken($token)
    //                 ->acceptJson()
    //                 ->post('https://administrative.easetravelandtours.com/v/public/api/v3/emp/auth');

    //             $data = $response->json();

    //             if ($data['code'] === 200) {
    //                 session([
    //                     'api_token' => $token,
    //                     'token' => $token,
    //                     '_creds' => (object) $data['content'],
    //                 ]);

    //                 // Redirect depending on role
    //                 if ($data['content']['emp_acc_role'] === 'admin') {
    //                     return redirect()->route('dashboard')->with('toast', 'Connected successfully!');
    //                 } elseif (str_starts_with($data['content']['emp_acc_role'], 'employee')) {
    //                     return redirect()->route('dashboard')->with('toast', 'Connected successfully!');
    //                 } else {
    //                     return redirect()->route('landing_page');
    //                 }
    //             } else {
    //                 return redirect('https://easetravelandtours.com/login');
    //             }
    //         } catch (\Throwable $e) {
    //             return redirect('https://easetravelandtours.com/login');
    //         }
    //     });
    //     Route::get('/check-session', function () {
    //         return session('_creds') ?? 'NO SESSION';
    //     });
    // Logout Session or Token
        Route::get('/logout', function(){
            session()->flush();
            return redirect('https://easetravelandtours.com/logout');
        })->name('logout');

    // Client Routes
    Route::get('/', [ClientController::class, 'landing_page'])->name('landing_page');
    Route::get('/register', [ClientController::class, 'register'])->name('register');
    Route::post('/register', [ClientController::class, 'store'])->name('register.store');






