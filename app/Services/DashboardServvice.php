<?php

namespace App\Services;

use App\Models\Course;

class DashboardServvice
{
    public function getSummary(Course $course)
    {
        return [
            'quiz_count' => $course->quizzes()->count(),
            'submission_count' =>
        ]
    }
}
