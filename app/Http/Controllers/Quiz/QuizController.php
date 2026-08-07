<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class QuizController extends Controller
{
    public function index(Request $request, Course $course)
    {

        $query = $course->quizzes()
            ->withCount('questions')
            ->get();

        return Inertia::render('Quiz/QuizPage', [
            'course' => $course,
            'quizzes' => $query,
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
            'description' => ['string'],
            'time_limit' => ['nullable'],

            'questions' => ['nullable', 'array'],
            'questions.*.id' => ['required', Rule::exists('questions', 'id')],
            'questions.*.weight' => ['required', 'numeric', 'min:0'],
            'questions.*.position' => ['required', 'integer', 'min:1'],
            'questions.*.is_bonus' => ['required', 'boolean'],
            'questions.*.is_optional' => ['required', 'boolean'],
        ]);

        DB::transaction(function () use ($course, $validated) {
            $quiz = $course->quizzes()->create([
                'title'=> $validated['title'],
                'description'=> $validated['description'] ?? null,
                'time_limit'=> $validated['time_limit'] ?? null,
            ]);

            if (!empty($validated['questions'])) {
                $attachData = [];

                foreach ($validated['questions'] as $q) {
                    $attachData[$q['id']] = [
                        'weight' => $q['weight'],
                        'position' => $q['position'],
                        'is_bonus' => $q['is_bonus'],
                        'is_optional' => $q['is_optional'],
                    ];
                }

                $quiz->questions()->attach($attachData);
            }
        }); 

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
