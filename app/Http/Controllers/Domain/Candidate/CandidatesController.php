<?php

namespace App\Http\Controllers\Domain\Candidate;

use App\Actions\Domain\Candidate\UpdateProfileAction;
use App\Http\Requests\Domain\Candidate\Profile\UpdateProfileRequest;
use App\Http\Resources\Domain\Candidate\ProfileResource;
use App\Supports\ApiReturnResponse;
use Illuminate\Http\JsonResponse;

class CandidatesController extends BaseController
{
    public function getProfile(): JsonResponse
    {
        return ApiReturnResponse::success(new ProfileResource($this->user));
    }

    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        //update profile
        $user = (new UpdateProfileAction)->execute($this->user, $request->input());

        //return response
        return $user
            ? ApiReturnResponse::success(new ProfileResource($user))
            : ApiReturnResponse::failed();
    }
}
