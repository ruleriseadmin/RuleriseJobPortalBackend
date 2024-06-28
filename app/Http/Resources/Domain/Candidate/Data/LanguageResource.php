<?php

namespace App\Http\Resources\Domain\Candidate\Data;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Supports\HelperSupport;

class LanguageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $response = collect(parent::toArray($request))->except([
            'created_at',
            'updated_at',
            'deleted_at',
            'user_id',
            'id',
        ])->toArray();

        return HelperSupport::snake_to_camel($response);
    }
}
