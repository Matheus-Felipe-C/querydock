<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuizController extends Controller
{
    public function index(Course $course)
    {

        return Inertia::render('Quiz/QuizPage', [
            'course' => $course,
            'quizzes' => [],
        ]);
    }
}
