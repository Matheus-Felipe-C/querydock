<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Question;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DevController extends Controller
{
    public function questionBank()
    {
        return Inertia::render('Quiz/QuestionBank', [
            'course' => $this->fakeCourse(),
            'questions' => Question::factory()->count(15)->make(),
        ]);
    }

    public function editQuestion() {
        return Inertia::render('Quiz/QuestionEditPage', [
            'course' => $this->fakeCourse(),
            'questions' => Question::factory()->make(),
        ]);
    }

    private function fakeCourse() {
        return Course::factory()->make([
            'id' => 1,
            'lti_context_id' => 'course-123',
            'lti_platform_id' => 1,
            'name' => 'Database Systems',
        ]);
    }
}
