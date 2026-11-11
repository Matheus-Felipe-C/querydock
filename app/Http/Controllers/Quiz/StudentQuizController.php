<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use Inertia\Inertia;

class StudentQuizController extends Controller
{
    public function show(Course $course, Quiz $quiz)
    {
        abort_unless((int) session('course_id') === $course->id, 403);

        return Inertia::render('Student/QuizAttempt/QuizAttemptPage', [
            'course' => $course,
            'quiz' => $quiz,
        ]);
    }
}
