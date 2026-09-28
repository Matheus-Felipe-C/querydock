<?php

namespace App\Services;

use \Illuminate\Database\Eloquent\Collection as Collection;
use App\Enums\SubmissionStatus;
use App\Models\Quiz;

class QuizSummaryService
{
    public function getSummary(Quiz $quiz): array
    {
        $submissions = $quiz->submissions()
            ->get(['id', 'status', 'score', 'started_at', 'completed_at']);

        $completed = $submissions->where('status', SubmissionStatus::Completed);

        return [
            'submission_count' => $submissions->count(),
            'avg_score' => $completed->avg('score'),
            'median_score' => $completed->median('median_score'),
            'avg_completion_seconds' => $completed
                ->map(fn ($s) => $s->completionSeconds())
                ->filter()
                ->avg(),
        ];
    }

    public function getRecentSubmissions(Quiz $quiz, int $limit = 10): Collection
    {
        return $quiz->submissions()
            ->with(['student:id, name', 'grader:id, name'])
            ->latest('updated_at')
            ->limit($limit)
            ->get();
    }

    public function getQuizData(Quiz $quiz): array
    {
        return [
            'summary' =>$this->getSummary($quiz),
            'recent_submissions' => $this->getRecentSubmissions($quiz),
        ];
    }
}
