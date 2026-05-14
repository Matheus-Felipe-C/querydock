<?php

namespace App\Http\Controllers;

use App\Services\LtiSyncService;
use Illuminate\Http\Request;
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

            if ($tool->getLaunchType() === $tool::LAUNCH_TYPE_LAUNCH) {
               ['platform' => $platform, 'user' => $user, 'course' => $course] = $this->ltiSyncService->sync($tool);

               session([
                'lti_authenticated' => true,
                'platform_id' => $platform->id,
                'user_id' => $user->id,
                'course_id' => $course?->id,
                'resource_link_id' => $tool->resourceLink->getRecordId(),
               ]);

                return redirect('/app');
            }

            abort(400, 'unknown message type');
        } catch (LtiException $e) {
            abort(400, $e->getMessage());
        }
    }
}
