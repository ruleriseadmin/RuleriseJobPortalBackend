<?php

namespace App\Http\Controllers\Domain\Admin\Candidate;
use App\Actions\Domain\Admin\AccountModeration\SetAccountActiveAction;
use App\Actions\Domain\Candidate\DeleteAccountAction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Supports\ApiReturnResponse;
use App\Models\Domain\Candidate\User;
use App\Http\Controllers\Domain\Admin\BaseController;
use App\Http\Resources\Domain\Admin\Candidate\CandidateResource;
use App\Http\Requests\Domain\Admin\Candidate\CandidateFilterRequest;
use App\Http\Resources\Domain\Admin\Candidate\CandidateFilterResource;

class CandidatesController extends BaseController
{
    public function index(CandidateFilterRequest $request): JsonResponse
    {
        return ApiReturnResponse::success(new CandidateFilterResource($request->input()));
    }

    public function show(string $uuid, Request $request): JsonResponse
    {
        $candidate = User::whereUuid($uuid);

        if ( ! $candidate ) return ApiReturnResponse::notFound('Candidate does not exists');

        $candidate['filter_by'] = $request->input('filterBy') ?? 'profile_details';

        return ApiReturnResponse::success(new CandidateResource($candidate));
    }

    public function delete(string $uuid): JsonResponse
    {
        $candidate = User::whereUuid($uuid);

        if ( ! $candidate ) return ApiReturnResponse::notFound('Candidate does not exists');

        return (new DeleteAccountAction)->execute($candidate)
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }

    public function moderateAccountStatus(string $uuid): JsonResponse
    {
        $candidate = User::whereUuid($uuid);

        if ( ! $candidate ) return ApiReturnResponse::notFound('Candidate does not exists');

        return (new SetAccountActiveAction)->execute($candidate)
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }
}
