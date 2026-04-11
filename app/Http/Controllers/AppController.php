<?php

namespace App\Http\Controllers;
use Inertia\Inertia;

class AppController extends Controller
{
    public function index() {
        return Inertia::render('Home', [
            'user_id' => session('user_id'),
            'context_id' => session('context_id'),
        ]);
    }
}
