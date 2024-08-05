<?php

namespace App\Actions\Domain\Employer\Template\JobNotificationTemplate;

use App\Models\Domain\Employer\Employer;
use Exception;

class ProcessDefaultNotificationTemplateAction
{
    public function execute(Employer $employer)
    {
        $templates = [
           'rejectedTemplate' => [
                'in_app_message' => 'We regret to inform on your application for {JOB_TITLE} role',
                'email' => 'We regret to inform on your application for {JOB_TITLE} role',
                'subject' => '{JOB_TITLE}: Application Update Notification',
            ],
            'shortlistedTemplate' => [
                'in_app_message' => 'You have been shortlisted for {JOB_TITLE} role',
                'email' => 'You have been shortlisted for {JOB_TITLE} role',
                'subject' => '{JOB_TITLE}: Application Update Notification',
            ],
            'offerSentTemplate' => [
                'in_app_message' => 'We happy to extend an offer to you for {JOB_TITLE} role',
                'email' => 'We happy to extend an offer to you for {JOB_TITLE} role',
                'subject' => '{JOB_TITLE}: Application Update Notification',
            ],
        ];

        try{
            (new CreateJobNotificationTemplateAction)->execute($employer, $templates);
        }catch(Exception $ex){
            throw new Exception("Could not process default job template - {$ex->getMessage()}");
        }
    }
}
