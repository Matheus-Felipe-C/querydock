<?php

namespace App\Http\Controllers;
use App\Models\User;
use Inertia\Inertia;

class AppController extends Controller
{
    public function index() {
        $user = User::find(session('user_id'));

        return Inertia::render('Home', [
            'user' => $user,
        ]);
    }
}
