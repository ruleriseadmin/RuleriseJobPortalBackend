<?php

namespace App\Http\Controllers\Domain\Employer\Template;
use App\Http\Resources\Domain\Employer\Template\JobNotificationTemplateResource;
use App\Supports\ApiReturnResponse;
use App\Http\Controllers\Domain\Employer\BaseController;
use App\Http\Requests\Domain\Employer\Template\JobNotificationTemplateRequest;
use App\Actions\Domain\Employer\Template\JobNotificationTemplate\UpdateJobNotificationTemplateAction;

class JobNotificationTemplatesController extends BaseController
{
    public function index()
    {
        return ApiReturnResponse::success(new JobNotificationTemplateResource($this->employer->jobNotificationTemplate));
    }

    public function updateTemplate(JobNotificationTemplateRequest $request)
    {
        $jobNotificationTemplate = $this->employer->jobNotificationTemplate;

        $template = (new UpdateJobNotificationTemplateAction)
            ->execute($jobNotificationTemplate, $request->input());

        return $template
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }


}
