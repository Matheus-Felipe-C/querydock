<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Services\LtiSyncService;
use ceLTIc\LTI\Content\Item;
use ceLTIc\LTI\Content\LtiLinkItem;
use ceLTIc\LTI\Enum\LtiVersion;
use ceLTIc\LTI\Platform;
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

               $quizId = $tool->getMessageParameters()['custom_quiz_id'] ?? null;

               $quiz = ($quizId && $course)
                   ? Quiz::where('id', $quizId)->where('course_id', $course->id)->first()
                   : null;

               if ($quiz) {
                   $isInstructor = in_array($role, ['instructor', 'teacher'], true);

                   return $isInstructor
                       ? redirect()->route('instructor.courses.quizzes.dashboard', [$course, $quiz])
                       : redirect()->route('student.courses.quizzes.show', [$course, $quiz]);
               }

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
                'platform_record_id' => $tool->platform->getRecordId(),
            ],
        ]);

        $quizzes = Quiz::query()
            ->when($course, fn ($q) => $q->where('course_id', $course->id))
            ->select('id', 'title')
            ->orderBy('title')
            ->get();

        return Inertia::render('Instructor/QuizSelection/QuizSelectionPage', [
            'quizzes' => $quizzes,
            'course' => $course,
        ]);
    }

    public function storeDeepLink(Request $request) {
        $validated = $request->validate([
            'quiz_id' => ['required', 'integer', 'exists:quizzes,id'],
        ]);

        $deepLink = session('lti_deep_link');
        abort_unless($deepLink, 403, 'No deep link request in progress.');
        abort_unless(in_array(session('lti_role'), ['instructor', 'teacher'], true), 403);

        $quiz = Quiz::findOrFail($validated['quiz_id']);

        $tool = LtiTool::getLtiTool();
        $platform = Platform::fromRecordId($deepLink['platform_record_id'], $tool->getDataConnector());
        $version = $platform->ltiVersion ?? LtiVersion::V1P3;

        $tool->platform = $platform;

        $item = new LtiLinkItem();
        $item->setTitle($quiz->title);
        $item->setUrl(url('/lti'));
        $item->addCustom('quiz_id', (string) $quiz->id);

        $formParams = ['content_items' => Item::toJson([$item], $version)];

        if (!empty($deepLink['data'])) {
            $formParams['data'] = $deepLink['data'];
        }

        $signed = $tool->signParameters(
            $deepLink['return_url'],
            'LtiDeepLinkingResponse',
            $version->value,
            $formParams,
        );

        abort_unless(is_array($signed) && isset($signed['JWT']), 500, 'Signing failed: ' . ($tool->reason ?? 'No JWT generated'));

        session()->forget('lti_deep_link');

        return Inertia::render('Instructor/QuizSelection/DeepLinkReturn', [
            'returnUrl' => $deepLink['return_url'],
            'fields' => $signed,
        ]);
    }
}
