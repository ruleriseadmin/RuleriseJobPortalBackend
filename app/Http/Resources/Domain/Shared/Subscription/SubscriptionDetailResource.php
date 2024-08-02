<?php

namespace App\Http\Resources\Domain\Shared\Subscription;

use App\Supports\HelperSupport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class SubscriptionDetailResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $response = collect([
            'status' => 'none',
        ]);

        if ( $this->hasActiveSubscription() ){
            $activeSubscription = $this->activeSubscription();

            $subscriptionUsage = $this->subscriptionUsage();

            $response = $request->merge([
                'name' => $activeSubscription->subscriptionPlan->name,
                'start_at' => Carbon::parse($activeSubscription->start_at)->toDateTimeString(),
                'end_at' => Carbon::parse($activeSubscription->end_at)->toDateTimeString(),
                'has_quota' => $this->hasSubscriptionQuota(),
                'quota_remaining' => $subscriptionUsage?->quota_remaining,
                'quota_used' => $subscriptionUsage?->quota_used,
            ]);

            $response['status'] = 'active';
        }

        return HelperSupport::snake_to_camel($response->toArray());
    }
}
