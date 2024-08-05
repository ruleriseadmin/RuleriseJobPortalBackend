<?php

use Database\Seeders\RoleSeeder;
use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerUser;
use App\Models\Domain\Employer\EmployerAccess;
use App\Models\Domain\Employer\Template\JobNotificationTemplate;
use App\Actions\Domain\Employer\Template\JobNotificationTemplate\ProcessDefaultNotificationTemplateAction;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('That employer create job notification template', function () {
    $employer = Employer::factory()->create();

    (new ProcessDefaultNotificationTemplateAction)->execute($employer);

    expect((bool) $employer->jobNotificationTemplate)->toBeTrue();
});

test('That employer job notification template is updated', function () {

    $employer = Employer::factory()->create();

    $user = EmployerUser::factory()->create();

    EmployerAccess::factory()->create();

    JobNotificationTemplate::factory()->create();

    $response = $this->actingAs($user)->post("/v1/employer/job-notification-template", [
        'notificationType' => JobNotificationTemplate::TEMPLATES['rejected_template'],
        'template' => [
            'in_app_message' => 'Testing in app message',
            'email' => 'Testing in email',
            'subject' => 'Testing in subject',
        ],
    ]);

    expect($response->json()['status'])->toBe('200');

    expect($employer->jobNotificationTemplate->rejected_template['in_app_message'])->toBe('Testing in app message');

    expect($employer->jobNotificationTemplate->rejected_template['email'])->toBe('Testing in email');

    expect($employer->jobNotificationTemplate->rejected_template['subject'])->toBe('Testing in subject');
});
