<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use ceLTIc\LTI;

#[Signature('app:create-lti-platform')]
#[Description('Command description')]
class CreateLtiPlatform extends Command
{
    protected $signature = 'lti:create-platform';
    protected $description = 'Create LTI platform';
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dataConnector = app('lti.data_connector');

        $platform = LTI\Platform::fromPlatformId(
            'https://moodle.matheusfelipe.dev',
            '3X854LOb4jpat3x',
            '2',
            $dataConnector
        );

        $platform->name = 'Local Moodle';
        $platform->authenticationUrl = 'https://moodle.matheusfelipe.dev/mod/lti/auth.php';
        $platform->accessTokenUrl = 'https://moodle.matheusfelipe.dev/mod/lti/token.php';
        $platform->jku = 'https://moodle.matheusfelipe.dev/mod/lti/certs.php';
    }
}
