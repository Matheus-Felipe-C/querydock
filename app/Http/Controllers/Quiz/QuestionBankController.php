<?php

namespace App\Http\Controllers\Quiz;

use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

class QuestionBankController extends Controller
{
    public function index(Course $course)
    {
        $course->load("questions");

        return Inertia::render('Quiz/QuestionBank', [
            'questions' => $course->questions,
        ]);
    }
}
