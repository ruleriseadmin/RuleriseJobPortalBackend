<?php

namespace App\Http\Controllers\Domain\Employer\Candidate;
use Illuminate\Http\JsonResponse;
use App\Supports\ApiReturnResponse;
use App\Models\Domain\Candidate\User;
use App\Http\Controllers\Domain\Employer\BaseController;
use App\Http\Resources\Domain\Employer\Candidate\CandidateResource;
use App\Http\Requests\Domain\Employer\Candidate\ChangeHiringStageRequest;
use App\Http\Resources\Domain\Employer\Candidate\CandidateFilterResource;

class CandidatesController extends BaseController
{
    public function index(): JsonResponse
    {
        return ApiReturnResponse::success(new CandidateFilterResource($this->employer));
    }

    public function show(string $uuid)
    {
        $candidate = User::where('uuid', $uuid)->first();

        return $candidate
            ? ApiReturnResponse::success(new CandidateResource($candidate))
            : ApiReturnResponse::notFound('Candidate not found');
    }

    public function changeHiringStage(ChangeHiringStageRequest $request)
    {
        return ApiReturnResponse::success();
    }
}
