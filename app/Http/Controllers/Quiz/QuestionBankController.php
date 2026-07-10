<?php

namespace App\Http\Controllers\Quiz;

use App\Models\Course;
use App\Models\Question;
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

    public function create(Course $course)
    {
        return Inertia::render('Quiz/QuestionCreatePage', [
            'course' => $course
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
            'expected_answer' => ['nullable', 'string'],
        ]);

        $course->questions()->create($validated);

        return redirect()->route('courses.questions.index', $course);
    }

    public function edit(Course $course, Question $question) {
        return Inertia::render('Quiz/QuestionEditPage', [
            'course' => $course,
            'question' => $question
        ]);
    }

    public function update(Request $request, Course $course, Question $question) {
        $validated = $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'difficulty' => ['required'],
            'topics' => ['array'],
            'topics.*' => ['string', 'max:50'],
            'expected_answer' => ['nullable', 'string'],
        ]);

        $question->update($validated);

        return redirect()->route('courses.questions.index', $course);
    }

    public function destroy(Request $request, Course $course, Question $question) {
        $question->delete();
        
        return redirect()->route('courses.questions.index', $course);
    }

}
