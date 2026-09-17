<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __construct(private DashboardService $dashboardService) {}
    public function show(Course $course)
    {
        $data = $this->dashboardService->getDashboardData($course);

        return Inertia::render('Dashboard/DashboardPage', $data);
    }

    public function indexQuizzes(Course $course)
    {
        $quizzes = $this->dashboardService->getRecentQuizzes($course);

        return Inertia::render('Dashboard/DashboardQuizzesPage', [
            'course' => $course,
            'recent_quizzes' => $quizzes
        ]);
    }
}
