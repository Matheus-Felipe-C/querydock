<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Dataset;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DatasetController extends Controller
{
    public function index(Course $course)
    {
        return Inertia::render('Quiz/DatasetPage', [
            'course' => $course,
            'datasets' => $course->datasets,
        ]);
    }

    public function create(Course $course)
    {
        return Inertia::render('Quiz/CreateDatasetPage',[
            'course' => $course,
        ]);
    }

    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'sql_script' => ['required', 'string'],
        ]);

        $course->datasets()->create($validated);

        return redirect()->route('courses.datasets.index', $course->id)->with('success','');
    }

    public function edit(Course $course, Dataset $dataset)
    {
        return Inertia::render('Quiz/EditDatasetPage', [
            'course' => $course,
            'dataset' => $dataset,
        ]);
    }

    public function update(Request $request, Course $course, Dataset $dataset)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'sql_script' => ['required', 'string'],
        ]);

        $dataset->update($validated);

        return redirect()->route('courses.datasets.index', $course->id)->with('success', '');
    }

    public function destroy(Course $course, Dataset $dataset)
    {
        $dataset->delete();

        return redirect()->route('courses.datasets.index', $course->id)->with('success','');
    }
}
