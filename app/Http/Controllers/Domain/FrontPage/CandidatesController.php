<?php

namespace App\Http\Controllers\Domain\FrontPage;

use App\Http\Resources\Domain\Candidate\ProfileResource;
use App\Models\Domain\Candidate\User;
use App\Supports\ApiReturnResponse;

class CandidatesController
{
    public function show(string $uuid)
    {
        $candidate = User::whereUuid($uuid);

        return $candidate
            ? ApiReturnResponse::success(new ProfileResource($candidate))
            : ApiReturnResponse::notFound('Candidate not found');
    }
}
