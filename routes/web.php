<?php

use App\Http\Controllers\AppController;
use App\Http\Middleware\EnsureLTISession;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('Home');
})->name('welcome');

// Public (LTI entry)
Route::any('/lti', [App\Http\Controllers\LTIController::class, 'ltiMessage']);
Route::get('/lti/jwks', [App\Http\Controllers\LTIController::class, 'getJWKS']);

//General app route for now
Route::middleware(['web', EnsureLTISession::class])->group(function () {
    Route::get('/app', [AppController::class, 'index']);
});