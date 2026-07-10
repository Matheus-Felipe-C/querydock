<?php

namespace App\Http\Controllers\Quiz;

use App\Models\Course;
use App\Models\Question;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

class QuestionBankController extends Controller
{
    public function index(Request $request, Course $course)
    {
        $query = $course->questions();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                ->orWhere('descriptiom', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        if ($request->filled('topic')) {
            $query->whereJsonContains('topics', $request->topic);
        }

        if ($request->sort === 'oldest') {
            $query->oldest();
        } else {
            $query->latest();
        }

        return Inertia::render('Quiz/QuestionBank', [
            'course' => $course,
            'questions' => $query
                ->paginate(12)
                ->withQueryString(),
            'topics' => $course->questions
                ->pluck('topics')
                ->flatten()
                ->unique()
                ->sort()
                ->values(),
                

            'filters' => [
                'search' => $request->search,
                'difficulty' => $request->difficulty,
                'topic' => $request->topic,
                'sort' => $request->sort,
            ],
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
