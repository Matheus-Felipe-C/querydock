<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuizController extends Controller
{
    public function index(Request $request, Course $course)
    {

        $query = $course->quizzes();

        return Inertia::render('Quiz/QuizPage', [
            'course' => $course,
            'quizzes' => $query->get(),
        ]);
    }

    public function create(Course $course)
    {
        return Inertia::render('Quiz/QuizCreatePage', [
            'course' => $course,
        ]);
    }

    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'time_limit' => ['nullable'],
        ]);

        $course->quizzes()->create($validated);

        return redirect()->route('courses.quizzes.index', $course);
    }

    public function edit(Course $course, Quiz $quiz)
    {
        return Inertia::render('Quiz/QuizEditPage', [
            'course' => $course,
            'quiz' => $quiz,
        ]);
    }

    public function update(Request $request, Course $course, Quiz $quiz)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'time_limit' => ['nullable'],
        ]);

        $quiz->update($validated);

        return redirect()->route('courses.quizzes.index', $course);
    }

    public function destroy(Course $course, Quiz $quiz)
    {
        $quiz->delete();

        return redirect()->route('courses.quizzes.index', $course);
    }
}
