<?php

namespace App\Http\Controllers\Domain\Employer\Candidate;
use Illuminate\Http\JsonResponse;
use App\Supports\ApiReturnResponse;
use App\Models\Domain\Candidate\User;
use App\Http\Controllers\Domain\Employer\BaseController;
use App\Http\Resources\Domain\Employer\Candidate\CandidateResource;
use App\Http\Requests\Domain\Employer\Candidate\ChangeHiringStageRequest;
use App\Http\Resources\Domain\Employer\Candidate\CandidateFilterResource;
use App\Actions\Domain\Employer\Candidate\ChangeApplicationHiringStageAction;

class CandidatesController extends BaseController
{
    public function index(): JsonResponse
    {
        return ApiReturnResponse::success(new CandidateFilterResource($this->employer));
    }


    public function changeHiringStage(ChangeHiringStageRequest $request)
    {
        return (new ChangeApplicationHiringStageAction)->execute($request->input())
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }
}
