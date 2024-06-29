<?php

namespace App\Http\Controllers\Domain\Candidate\Data;

use App\Actions\Domain\Candidate\CandidateCredential\CreateCandidateCredentialAction;
use App\Actions\Domain\Candidate\CandidateCredential\DeleteCandidateCredentialAction;
use App\Actions\Domain\Candidate\CandidateCredential\UpdateCandidateCredentialAction;
use App\Http\Controllers\Domain\Candidate\BaseController;
use App\Http\Requests\Domain\Candidate\CandidateCredential\StoreCandidateCredentialRequest;
use App\Http\Requests\Domain\Candidate\CandidateCredential\UpdateCandidateCredentialRequest;
use App\Http\Resources\Domain\Candidate\Data\CredentialResource;
use App\Supports\ApiReturnResponse;
use Illuminate\Http\JsonResponse;

class CredentialsController extends BaseController
{
    public function store(StoreCandidateCredentialRequest $request) : JsonResponse
    {
        $credential = (new CreateCandidateCredentialAction)->execute($this->user, $request->input());

        //return response
        return $credential ? ApiReturnResponse::success(new CredentialResource($credential)) : ApiReturnResponse::failed();
    }

    public function update(UpdateCandidateCredentialRequest $request) : JsonResponse
    {
        $credential = $this->user->credentials()->where('uuid', $request->input('uuid'))->first();

        if ( ! $credential ) return ApiReturnResponse::notFound('Credential does not exists');

        //call action
        $credential = (new UpdateCandidateCredentialAction)->execute($credential, $request->input());

        //return response
        return $credential ? ApiReturnResponse::success(new CredentialResource($credential)) : ApiReturnResponse::failed();
    }

    public function delete(string $uuid) : JsonResponse
    {
        $credential = $this->user->credentials()->where('uuid', $uuid)->first();

        if ( ! $credential ) return ApiReturnResponse::notFound('Credential does not exists');

        return (new DeleteCandidateCredentialAction)->execute($credential)
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }
}
