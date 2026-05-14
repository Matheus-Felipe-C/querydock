<?php

namespace App\Services;

use App\Models\Course;
use App\Models\LtiPlatform;
use App\Models\User;
use LonghornOpen\LaravelCelticLTI\LtiTool;

class LtiSyncService
{
    
    public function sync(LtiTool $tool): array
    {
        $platform = LtiPlatform::updateOrCreate(
            [
                'issuer' => $tool->platform->platformId,
                'client_id' => $tool->platform->clientId,
            ]
        );

        $user = User::updateOrCreate(
            [
                'lti_user_id' => $tool->userResult->ltiUserId,
                'lti_platform_id' => $platform->id,
            ],
            [
                'name' => $tool->userResult->fullname ?? '',
                'email' => $tool->userResult->email ?? null,
            ]
        );

        $course = null;

        if ($tool->context) {
            $course = Course::updateOrCreate(
                [
                    'lti_context_id' => $tool->context->getId(),
                    'lti_platform_id' => $platform->id,
                ],
                [
                    'name' => $tool->context->title ?? null,
                ]
            );

            $role = $tool->userResult->isStaff() ? 'instructor' : 'student';
            $user->courses()->syncWithoutDetaching([
                $course->id => ['role' => $role],
            ]);
        }

        return compact('platform', 'user', 'course');
    }
}
