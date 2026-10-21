<?php

namespace App\Http\Controllers;
use App\Models\User;
use Inertia\Inertia;

class AppController extends Controller
{
    public function index() {
        $user = User::find(session('user_id'));
        $role = session('lti_role');

        return Inertia::render(
            $role === 'instructor'
                ? 'Home'
                : 'Dashboard/DashboardPage',
            ['user' => $user]
        );
    }
}
