<?php

namespace App\Http\Controllers\Domain\Admin\Employer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Supports\ApiReturnResponse;
use App\Models\Domain\Employer\Employer;
use App\Actions\Domain\Employer\DeleteEmployerAction;
use App\Http\Controllers\Domain\Admin\BaseController;
use App\Http\Resources\Domain\Admin\Employer\EmployerResource;
use App\Actions\Domain\Admin\AccountModeration\SetShadowBanAction;
use App\Http\Requests\Domain\Admin\Employer\EmployerFilterRequest;
use App\Http\Requests\Domain\Admin\Moderation\SetShadowBanRequest;
use App\Http\Resources\Domain\Admin\Employer\EmployerFilterResource;
use App\Actions\Domain\Admin\AccountModeration\SetAccountActiveAction;

class EmployersController extends BaseController
{
    public function index(EmployerFilterRequest $request): JsonResponse
    {
        return ApiReturnResponse::success(new EmployerFilterResource($request->input()));
    }

    public function show(string $uuid, Request $request): JsonResponse
    {
        $employer = Employer::whereUuid($uuid);

        if ( ! $employer ) return ApiReturnResponse::notFound('Employer not found');

        $employer['filter_by'] = $request->input('filterBy') ?? 'profile_details';

        $request->filled('sortJobBy') ? $employer['sortJobBy'] = $request->input('sortJobBy') : null;

        return ApiReturnResponse::success(new EmployerResource($employer));
    }

    public function delete(string $uuid): JsonResponse
    {
        $employer = Employer::whereUuid($uuid);

        if ( ! $employer ) return ApiReturnResponse::notFound('Employer not found');

        return (new DeleteEmployerAction)->execute($employer, $employer->users()->first())
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }

    public function moderateAccountStatus(string $uuid): JsonResponse
    {
        $employer = Employer::whereUuid($uuid);

        if ( ! $employer ) return ApiReturnResponse::notFound('Employer not found');

        return (new SetAccountActiveAction)->execute($employer)
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }

    public function setShadowBan(string $uuid, SetShadowBanRequest $request): JsonResponse
    {
        $employer = Employer::whereUuid($uuid);

        if ( ! $employer ) return ApiReturnResponse::notFound('Employer not found');

        return (new SetShadowBanAction)->execute($employer, $request->input('type'))
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }
}
