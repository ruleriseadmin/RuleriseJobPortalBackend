<?php

namespace App\Http\Resources\Domain\FrontPage;

use App\Supports\HelperSupport;
use Illuminate\Http\Request;
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
            'created_at' => $this->created_at->toDateTimeString(),
            'employer_name' => $this->employer?->company_name,
            'employer_logo' => $this->employer->logo_url ? asset($this->employer->logo_url) : null,
        ]);

        return HelperSupport::snake_to_camel($response->toArray());
    }
}
