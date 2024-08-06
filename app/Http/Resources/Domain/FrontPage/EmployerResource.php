<?php

namespace App\Http\Resources\Domain\FrontPage;

use App\Supports\HelperSupport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return HelperSupport::snake_to_camel(collect(parent::toArray($request))->except([
            'id',
            'created_at',
        ])->toArray());
    }
}
