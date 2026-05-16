<?php

namespace Tests\Feature;

use App\Models\LtiPlatform;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class LtiSessionTest extends TestCase
{
    use RefreshDatabase;

    public function test_app_requires_lti_session(): void
    {
        $this->get('/app')->assertForbidden();
    }

    public function test_app_accepts_valid_signed_launch(): void
    {
        $platform = LtiPlatform::create([
            'issuer' => 'https://moodle.example',
            'client_id' => 'test-client',
        ]);
        $user = User::factory()->create([
            'lti_user_id' => 'lti-user-1',
            'lti_platform_id' => $platform->id,
        ]);

        $url = URL::temporarySignedRoute('app', now()->addMinutes(5), [
            'user_id' => $user->id,
            'platform_id' => $platform->id,
        ]);

        $this->get($url)
            ->assertSuccessful()
            ->assertSessionHas('lti_authenticated', true)
            ->assertSessionHas('user_id', $user->id);
    }

    public function test_app_rejects_tampered_signed_launch(): void
    {
        $platform = LtiPlatform::create([
            'issuer' => 'https://moodle.example',
            'client_id' => 'test-client-2',
        ]);
        $user = User::factory()->create([
            'lti_user_id' => 'lti-user-2',
            'lti_platform_id' => $platform->id,
        ]);

        $url = URL::temporarySignedRoute('app', now()->addMinutes(5), [
            'user_id' => $user->id,
            'platform_id' => $platform->id,
        ]);

        $tampered = preg_replace('/user_id=\d+/', 'user_id=99999', $url);

        $this->get($tampered)->assertForbidden();
    }
}
