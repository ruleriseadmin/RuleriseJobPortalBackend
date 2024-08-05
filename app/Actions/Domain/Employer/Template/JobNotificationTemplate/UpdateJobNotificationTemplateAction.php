<?php

namespace App\Actions\Domain\Employer\Template\JobNotificationTemplate;

use App\Models\Domain\Employer\Template\JobNotificationTemplate;
use Exception;
use Illuminate\Support\Facades\Log;

class UpdateJobNotificationTemplateAction
{
    public function execute(JobNotificationTemplate $jobNotificationTemplate, array $inputs): ?JobNotificationTemplate
    {
        try{
            $jobNotificationTemplate->update([
                $inputs['notificationType'] => $inputs['template'],
            ]);
        }catch(Exception $ex){
            Log::error("Error @ UpdateJobNotificationTemplateAction: " . $ex->getMessage());
            return null;
        };

        return $jobNotificationTemplate->refresh();
    }
}
