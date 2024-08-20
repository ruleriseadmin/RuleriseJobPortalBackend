<?php

namespace App\Http\Requests\Domain\Admin\Subscription\Plan;
use App\Http\Requests\BaseRequest;

class UpdatePlanRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'planId' => ['required', 'exists:subscription_plans,uuid'],
            'name' => ['required'],
            'active' => ['nullable', 'boolean'],
            'numberOfCandidate' => ['required'],
        ];
    }
}
