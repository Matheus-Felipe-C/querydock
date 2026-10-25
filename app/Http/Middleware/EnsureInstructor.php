<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureInstructor
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = session('user_id');
        $courseId = session('course_id');

        if (!$userId || !$courseId) {
            abort(403, 'Missing LTI user or course context');
        }

        $user = User::find($userId);

        if (!$user) {
            abort(403, 'User not found');
        }

        $isInstructor = $user->courses()
            ->where('course_id', $courseId)
            ->wherePivot('role', 'instructor')
            ->exists();

        if (!$isInstructor) {
            abort(403, 'Instructor access required');
        }

        return $next($request);
    }
}
