<?php

namespace App\Http\Resources\Domain\Candidate;

use App\Supports\HelperSupport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CVResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $response = collect(parent::toArray($request))->except([
            'id',
            'deleted_at',
            'user_id',
            'created_at',
            'updated_at',
        ]);

        $documentTitle = str_replace("cv/{$this->user->email}", str($this->user->fullName)->kebab(), $this->cv_document_url);

        $response = $response->merge([
            'documentTitle' => str_replace('-', ' ', $documentTitle),
            'uploaded_at' => $this->updated_at->toDateTimeString(),
        ]);

        return HelperSupport::snake_to_camel($response->toArray());
    }
}
