<?php

namespace App\Http\Requests\Domain\Admin\Subscription\Plan;
use App\Http\Requests\BaseRequest;

class SetActiveRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'planId' => ['required', 'exists:subscription_plans,uuid'],
            'active' => ['required', 'boolean'],
        ];
    }
}
