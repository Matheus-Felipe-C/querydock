<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use App\Services\QuizSummaryService;
use Inertia\Inertia;

class QuizSummaryController extends Controller
{
    public function __construct(private QuizSummaryService $quizSummaryService)
    {}

    public function show(Course $course, Quiz $quiz)
    {
        $data = $this->quizSummaryService->getQuizData($quiz);

        return Inertia::render('Quiz/QuizResultsPage', [
            'course' => $course,
            'quiz' => $quiz,
            'quizSummary' => $data
        ]);
    }
}
