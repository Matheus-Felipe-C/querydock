<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\Quiz\QuestionBankController;
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

Route::get('/quiz/question-bank', [QuestionBankController::class, 'index'])
    ->name('quiz.question-bank');

// Public (LTI entry)
Route::any('/lti', [App\Http\Controllers\LTIController::class, 'ltiMessage']);
Route::get('/lti/jwks', [App\Http\Controllers\LTIController::class, 'getJWKS']);

//General app route for now
Route::get('/app', [AppController::class, 'index'])
    ->middleware(EnsureLTISession::class)
    ->name('app');