<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Services\LtiSyncService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use LonghornOpen\LaravelCelticLTI\LtiException;
use LonghornOpen\LaravelCelticLTI\LtiTool;

class LTIController extends Controller
{
    public function __construct(protected LtiSyncService $ltiSyncService) {}
    public function getJWKS() {
        $tool = LtiTool::getLtiTool();
        return $tool->getJWKS();
    }

    public function ltiMessage(Request $request) {
        try {
            $tool = LtiTool::getLtiTool();
            $tool->handleRequest();

            if ($tool->getLaunchType() == LtiTool::LAUNCH_TYPE_CONTENT_ITEM) {
                return $this->handleDeepLinking($tool);
            }

            if ($tool->getLaunchType() === $tool::LAUNCH_TYPE_LAUNCH) {
               ['platform' => $platform, 'user' => $user, 'course' => $course, 'role' => $role] = $this->ltiSyncService->sync($tool);

               session([
                'lti_authenticated' => true,
                'platform_id' => $platform->id,
                'user_id' => $user->id,
                'course_id' => $course?->id,
                'resource_link_id' => $tool->resourceLink->getRecordId(),
                'lti_role' => $role,
               ]);

                return redirect('/app');
            }

            abort(400, 'unknown message type');
        } catch (LtiException $e) {
            abort(400, $e->getMessage());
        }
    }

    private function handleDeepLinking(LtiTool $tool) {
        $params = $tool->getMessageParameters();

        [
            'platform' => $platform,
            'user' => $user,
            'course' => $course,
            'role' => $role,
        ] = $this->ltiSyncService->sync($tool);

        abort_unless(
            in_array($role, ['instructor', 'teacher'], true),
            403,
            'Only teachers can select quizzes.'
        );

        session([
            'lti_authenticated' => true,
            'platform_id' => $platform->id,
            'user_id' => $user->id,
            'course_id' => $course?->id,
            'lti_role' => $role,

            'lti_deep_link' => [
                'return_url' => $tool->returnUrl,
                'data' => $params['data'] ?? null,
            ],
        ]);

        $quizzes = Quiz::query()
            ->select('id', 'title')
            ->orderBy('title')
            ->get();

        return Inertia::render('Instructor/QuizSelection/QuizSelectionPage', [
            'quizzes' => $quizzes,
            'course' => $course,
        ]);
    }
}
