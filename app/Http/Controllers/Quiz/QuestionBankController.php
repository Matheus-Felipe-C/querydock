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
            'course' => $course,
            'questions' => $course->questions,
        ]);
    }

    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'difficulty' => ['required', 'in:easy,medium,hard'],
            'topics' => 'array',
            'topics.*' => ['string', 'max:50'],
        ]);

        $course->questions()->create($validated);

        return redirect()->back();
    }
}
