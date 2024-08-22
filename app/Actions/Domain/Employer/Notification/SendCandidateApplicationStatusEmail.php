<?php

namespace App\Actions\Domain\Employer\Notification;

use App\Notifications\Domain\Shared\NotificationWithActionButton;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Candidate\Job\CandidateJobApplication;
use Illuminate\Support\Facades\Notification;

class SendCandidateApplicationStatusEmail
{
    public function execute(CandidateJobApplication $application, string $hiringStage)
    {
        if ( ! $application->job ) return;

        if ( ! $application->job->employer ) return;

        $template = "{$hiringStage}_template";

        $template = $application->job->employer->jobNotificationTemplate->$template;

        try{
            $user = $application->applicant;

            Notification::route('email', $user->email)->notify(new NotificationWithActionButton([
                'subject' => $template['subject'] ?? 'Application Status Update',
                'greeting' => $user->full_name,
                'messages' => [
                    $template['email'] ?? 'Your have an update on your job application.',
                    'Job Title: '.$application->job->title,
                ],
                'actionText' => 'View Job',
                'actionUrl' => config('env.candidate.base_url')."/job/{$application->job->id}",
            ]));
        }catch(Exception $ex){
            Log::error("Error @ SendCandidateApplicationStatusEmail: " . $ex->getMessage());
        }
    }
}
