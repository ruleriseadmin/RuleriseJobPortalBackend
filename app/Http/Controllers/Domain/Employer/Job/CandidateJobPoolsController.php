<?php

namespace App\Http\Controllers\Domain\Employer\Job;
use Illuminate\Http\JsonResponse;
use App\Supports\ApiReturnResponse;
use App\Http\Controllers\Domain\Employer\BaseController;
use App\Http\Requests\Domain\Employer\Job\AttachCandidatePoolRequest;
use App\Http\Requests\Domain\Employer\Job\CandidateJobPoolStoreRequest;
use App\Actions\Domain\Employer\Job\CandidateJobPool\AttachCandidatePoolAction;
use App\Actions\Domain\Employer\Job\CandidateJobPool\CreateCandidatePoolAction;
use App\Http\Resources\Domain\Employer\Candidate\CandidateJobPoolResource;

class CandidateJobPoolsController extends BaseController
{
    public function index(): JsonResponse
    {
        return ApiReturnResponse::success(CandidateJobPoolResource::collection($this->employer->candidatePools));
    }

    public function store(CandidateJobPoolStoreRequest $request): JsonResponse
    {
        $candidateJobPool = (new CreateCandidatePoolAction)
            ->execute($this->employer, $request->input());

        return $candidateJobPool
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }

    public function viewCandidate(string $uuid) : JsonResponse
    {
        $candidateJobPool = $this->employer->candidatePools
            ->where('uuid', $uuid)
            ->first();

        if ( ! $candidateJobPool ) return ApiReturnResponse::notFound('Candidate Job Pool not found');

        $candidateJobPool['with_candidate'] = true;

        return ApiReturnResponse::success(new CandidateJobPoolResource($candidateJobPool));
    }

    public function attachCandidatePool(AttachCandidatePoolRequest $request) : JsonResponse
    {
        //Attach and Detach candidates in candidate pool
        $attach = (new AttachCandidatePoolAction)
            ->execute($request->input());

        return $attach
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }
}
