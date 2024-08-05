<?php

namespace Database\Factories\Domain\Employer\Template;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain\Employer\Template\JobNotificationTemplate>
 */
class JobNotificationTemplateFactory extends Factory
{
    public function definition(): array
    {
        return [
            'employer_id' => 1,
            'rejected_template' => [
                'in_app_message' => 'We regret to inform on your application for {JOB_TITLE} role',
                'email' => 'We regret to inform on your application for {JOB_TITLE} role',
                'subject' => '{JOB_TITLE}: Application Update Notification',
            ],
            'shortlisted_template' => [
                'in_app_message' => 'You have been shortlisted for {JOB_TITLE} role',
                'email' => 'You have been shortlisted for {JOB_TITLE} role',
                'subject' => '{JOB_TITLE}: Application Update Notification',
            ],
            'offer_sent_template' => [
                'in_app_message' => 'We happy to extend an offer to you for {JOB_TITLE} role',
                'email' => 'We happy to extend an offer to you for {JOB_TITLE} role',
                'subject' => '{JOB_TITLE}: Application Update Notification',
            ],
        ];
    }
}
