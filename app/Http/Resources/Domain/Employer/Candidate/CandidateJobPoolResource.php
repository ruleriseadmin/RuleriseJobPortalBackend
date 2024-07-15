<?php

namespace App\Http\Resources\Domain\Employer\Candidate;

use App\Models\Domain\Candidate\User;
use App\Supports\HelperSupport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CandidateJobPoolResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $response = collect(parent::toArray($request))->except([
            'created_at',
            'deleted_at',
            'candidate_ids',
            'employer_id',
            'id',
        ]);

        $response = collect($response)->merge([
            'numberOfCandidates' => count($this->candidate_ids ?? []),
        ]);

        if ( $this->with_candidate ?? false ){
            $response = collect($response)->merge([
                'candidates' => CandidateResource::collection($this->getCandidates()),
            ]);
        }

        return HelperSupport::snake_to_camel($response->toArray());
    }
}
