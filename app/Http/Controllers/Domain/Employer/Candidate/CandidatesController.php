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

<<<<<<<<<<<<<<  ✨ Codeium Command ⭐  >>>>>>>>>>>>>>>>
    /**
     * Show a single candidate
     *
     * @param string $uuid
     * @return JsonResponse
     */
<<<<<<<  c4aa2d1c-c920-4b7e-bfd9-c02f6e406c58  >>>>>>>
    public function show(string $uuid)
    {
        $candidate = User::where('uuid', $uuid)->first();

        return $candidate
            ? ApiReturnResponse::success(new CandidateResource($candidate))
            : ApiReturnResponse::notFound('Candidate not found');
    }

    public function changeHiringStage(ChangeHiringStageRequest $request)
    {
        return (new ChangeApplicationHiringStageAction)->execute($request->input())
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }
}
