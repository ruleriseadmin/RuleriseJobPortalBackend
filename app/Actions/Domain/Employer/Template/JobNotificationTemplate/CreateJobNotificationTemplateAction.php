<?php

namespace App\Actions\Domain\Employer\Template\JobNotificationTemplate;

use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\Template\JobNotificationTemplate;
use Exception;
use Illuminate\Support\Facades\Log;

class CreateJobNotificationTemplateAction
{
    public function execute(Employer $employer, array $inputs): ? JobNotificationTemplate
    {
        try{
            $jobNotificationTemplate = $employer->jobNotificationTemplate()->create([
                'rejected_template' => $inputs['rejectedTemplate'],
                'shortlisted_template' => $inputs['shortlistedTemplate'],
                'offer_sent_template' => $inputs['offerSentTemplate'],
            ]);
        }catch(Exception $ex){
            Log::error("Error @ CreateJobNotificationTemplateAction: " . $ex->getMessage());
            throw new Exception("Could not create job template - {$ex->getMessage()}");
        }

        return $jobNotificationTemplate;
    }
}
