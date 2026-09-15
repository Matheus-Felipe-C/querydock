<?php

namespace App\Services;

use App\Models\Course;

class DashboardService
{
    public function getSummary(Course $course)
    {
        return [
            'quiz_count' => $course->quizzes()->count(),
            'submission_count' => $course->submissions()->count(),
            'avg_score' => $course->submissions()->avg('score'),
            'active_quiz_count' => $course->quizzes()->whereHas('submissions')->count(),
        ];
    }

    public function getRecentQuizzes(Course $course, int $limit = 6)
    {
        return $course->quizzes()
            ->withCount('questions')
            ->withCount('submissions')
            ->withAvg(['submissions as avg_score' => fn ($q) => $q->where('status', 'completed')], 'score')
            ->latest('updated_at')
            ->limit($limit)
            ->get();
    }

    public function getDashboardData(Course $course): array
    {
        return [
            'course' => $course,
            'summary' => $this->getSummary($course),
            'recent_quizzes' => $this->getRecentQuizzes($course),
        ];
    }
}
