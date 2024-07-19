<?php

namespace App\Http\Controllers\Domain\Shared\AccountSetting;

use Illuminate\Http\JsonResponse;
use App\Supports\ApiReturnResponse;
use App\Actions\Domain\Shared\AccountSetting\ChangePasswordAction;
use App\Http\Requests\Domain\Shared\AccountSetting\ChangePasswordRequest;

class ChangePasswordController
{
    public function store(ChangePasswordRequest $request): JsonResponse
    {
        $changePassword = (new ChangePasswordAction)->execute($request->input('password'));

        //@todo logout when change password

        return $changePassword ? ApiReturnResponse::success() : ApiReturnResponse::failed();
    }
}
