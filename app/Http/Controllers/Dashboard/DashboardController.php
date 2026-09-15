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
    public function index(Course $course)
    {
        $data = $this->dashboardService->getDashboardData($course);

        return Inertia::render('Dashboard', $data);
    }
}
