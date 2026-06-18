<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\Quiz\QuestionBankController;
use App\Http\Controllers\Quiz\QuizController;
use App\Http\Middleware\EnsureLTISession;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home', [
        'user' => [
            'name' => 'Test user',
        ]
    ]);
})->name('welcome');


// Route::get('/quiz', [QuizController::class, 'index'])->name('quiz');

Route::resource('courses.quizzes', QuizController::class);


Route::resource('courses.questions', QuestionBankController::class);
// Public (LTI entry)
Route::any('/lti', [App\Http\Controllers\LTIController::class, 'ltiMessage']);
Route::get('/lti/jwks', [App\Http\Controllers\LTIController::class, 'getJWKS']);

//General app route for now
Route::get('/app', [AppController::class, 'index'])
    ->middleware(EnsureLTISession::class)
    ->name('app');