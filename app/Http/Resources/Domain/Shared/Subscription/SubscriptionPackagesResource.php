<?php

namespace App\Http\Resources\Domain\Shared\Subscription;

use App\Supports\HelperSupport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionPackagesResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $response = collect(parent::toArray($request))->only([
            // 'id',
            // 'created_at',
            // 'updated_at',
            // 'deleted_at',
            // 'plan_id',
            // 'product_id',
            'uuid',
            'name',
            'amount',
            'currency',
            'interval',
            'interval_count',
        ]);

        $response = collect($response)->merge([
            'number_candidates' => $this->quota,
        ]);

        return HelperSupport::snake_to_camel($response->toArray());
    }
}
