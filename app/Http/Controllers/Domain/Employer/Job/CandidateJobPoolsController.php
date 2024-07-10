<?php

namespace App\Http\Controllers\Domain\Employer\Job;
use Illuminate\Http\JsonResponse;
use App\Supports\ApiReturnResponse;
use App\Http\Controllers\Domain\Employer\BaseController;
use App\Http\Requests\Domain\Employer\Job\CandidateJobPoolStoreRequest;
use App\Http\Controllers\Domain\Employer\Job\AttachCandidatePoolRequest;
use App\Actions\Domain\Employer\Job\CandidateJobPool\AttachCandidatePoolAction;
use App\Actions\Domain\Employer\Job\CandidateJobPool\CreateCandidatePoolAction;

class CandidateJobPoolsController extends BaseController
{
    public function store(CandidateJobPoolStoreRequest $request): JsonResponse
    {
        $candidateJobPool = (new CreateCandidatePoolAction)
            ->execute($this->employer, $request->input());

        return $candidateJobPool
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
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
