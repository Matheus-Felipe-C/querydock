<?php

namespace App\Http\Controllers\Quiz;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

class QuestionBankController extends Controller
{
    public function index()
    {
        return Inertia::render('Quiz/QuestionBank');
    }
}
