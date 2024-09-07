<?php

namespace App\Http\Resources\Domain\FrontPage;

use Illuminate\Http\Request;
use App\Supports\HelperSupport;
use App\Models\Domain\Admin\GeneralSetting;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $response = collect(parent::toArray($request))->except([
            'id',
            'created_at',
            'updated_at',
            'deleted_at',
            'employer_id',
            'employer',
        ]);

        $response = $response->merge([
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'employer_name' => $this->employer?->company_name,
            'employer_logo' => $this->employer->logo_url ? asset("storage/{$this->employer->logo_url}") : null,
            'currency' => GeneralSetting::defaultCurrency(),
        ]);

        return HelperSupport::snake_to_camel($response->toArray());
    }
}
