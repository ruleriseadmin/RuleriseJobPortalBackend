<?php

namespace App\Http\Requests\Domain\Admin\Subscription\Plan;
use App\Http\Requests\BaseRequest;

class StorePlanRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'planId' => ['required', 'exists:subscription_plans,uuid'],
            'name' => ['required'],
            'price' => ['required'],
            'interval' => ['required'],
            'duration' => ['required'],
            'numberOfCandidate' => ['required'],
        ];
    }
}
