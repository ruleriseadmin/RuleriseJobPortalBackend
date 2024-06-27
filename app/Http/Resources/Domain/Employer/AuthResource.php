<?php

namespace App\Http\Resources\Domain\Employer;

use App\Supports\HelperSupport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $response = collect(parent::toArray($request))->except([
            'created_at',
            'updated_at',
            'deleted_at',
            'id',
        ]);

        $response = $response
            ->merge(collect($this->employers->first()->pivot)->except(['employer_user_id', 'employer_id']))
            // ->merge([
            //     'employer' => (new EmployerResource($this->employers->first())),
            // ])
            ->toArray();

        return HelperSupport::snake_to_camel($response);
    }
}
