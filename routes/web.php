<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\DevController;
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

Route::resource('courses.quizzes', QuizController::class)->scoped();


Route::resource('courses.questions', QuestionBankController::class)->scoped();
// Public (LTI entry)
Route::any('/lti', [App\Http\Controllers\LTIController::class, 'ltiMessage']);
Route::get('/lti/jwks', [App\Http\Controllers\LTIController::class, 'getJWKS']);

//General app route for now
Route::get('/app', [AppController::class, 'index'])
    ->middleware(EnsureLTISession::class)
    ->name('app');

// Dev only routes. Will use mocked data for local testing purposes
if (app()->environment('local')) {
    Route::prefix('dev')->group(function () {
        Route::get('/question-edit', [DevController::class, 'editQuestion']);
        Route::get('/question-bank', [DevController::class, 'questionBank']);
        Route::get('/quiz-list', [DevController::class, 'quizList']);
    });
}