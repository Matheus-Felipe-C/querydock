<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LonghornOpen\LaravelCelticLTI\LtiException;
use LonghornOpen\LaravelCelticLTI\LtiTool;

class LTIController extends Controller
{
    public function getJWKS() {
        $tool = LtiTool::getLtiTool();
        return $tool->getJWKS();
    }

    public function ltiMessage(Request $request) {
        try {
            $tool = LtiTool::getLtiTool();
            $tool->handleRequest();

            if ($tool->getLaunchType() === $tool::LAUNCH_TYPE_LAUNCH) {
                /*
                At this point:
                  $tool->platform describes the platform (LMS)
                  $tool->context describes the context (course)
                  $tool->resourceLink describes the resourceLink (tool placement in course)
                  $tool->userResult describes the user.

                Each of these has a getRecordId() function which returns a database primary key.
                Store these keys in a session or in your app's database for later lookup.
                If your app has database tables corresponding to courses, users, etc you can store this primary key in that table.
                */

                session([
                    'lti_authenticated' => true,
                    'context_id' => $tool->context?->getRecordId(),
                    'platform_id' => $tool->platform?->getRecordId(),
                    'user_id' => $tool->userResult->getRecordId(),
                    'resource_link_id' => $tool->resourceLink?->getRecordId(),
                ]);

                return redirect('/app');
            }

            abort(400, 'unknown message type');
        } catch (LtiException $e) {
            abort(400, $e->getMessage());
        }
    }
}
