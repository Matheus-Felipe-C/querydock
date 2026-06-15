<?php

namespace App\Http\Middleware;

use App\Models\Course;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureLTISession
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Allow static assets
        if (
            $request->is('build/*') ||
            $request->is('build/assets/*') ||
            $request->is('resources/*') ||
            $request->is('js/*') ||
            $request->is('css/*') ||
            $request->is('favicon.ico')
        ) {
            return $next($request);
        }

        if (!session('lti_authenticated')) {
            abort(403, 'Unauthorized LTI access');
        }

        $user = User::find(session('user_id'));

        if (!$user) {
            abort(403, 'Unauthorized LTI access');
        }

        $course = session('course_id')
            ? Course::find(session('course_id'))
            : null;

        $request->attributes->set('lti_user', $user);
        $request->attributes->set('lti_course', $course);

        return $next($request);
    }
}