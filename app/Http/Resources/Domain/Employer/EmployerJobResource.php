<?php

namespace App\Http\Resources\Domain\Employer;

use Illuminate\Http\Request;
use App\Supports\HelperSupport;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployerJobResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $response = collect(parent::toArray($request))->except([
            'id',
            'created_at',
            'updated_at',
            'deleted_at',
        ]);

        return HelperSupport::snake_to_camel($response->toArray());
    }
}
