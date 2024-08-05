<?php

namespace App\Http\Requests\Domain\Employer\Template;
use App\Http\Requests\BaseRequest;
use App\Models\Domain\Employer\Template\JobNotificationTemplate;
use Illuminate\Validation\Rule;

class JobNotificationTemplateRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'notificationType' => ['required', Rule::in(JobNotificationTemplate::TEMPLATES)],
            'template' => ['required'],
            'template.in_app_message' => ['required'],
            'template.email' => ['required'],
            'template.subject' => ['required'],
        ];
    }
}
