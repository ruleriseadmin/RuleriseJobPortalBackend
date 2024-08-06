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
        ]);

        $response = $response->merge([
            'created_at' => $this->created_at->toDateTimeString(),
        ]);

        return HelperSupport::snake_to_camel($response->toArray());
    }
}
