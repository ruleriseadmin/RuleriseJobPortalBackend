<?php

namespace App\Http\Controllers\Domain\Admin\GeneralSetting;

use App\Supports\ApiReturnResponse;
use App\Http\Resources\Domain\Admin\GeneralSettingResource;
use App\Actions\Domain\Admin\GeneralSetting\SetGeneralSettingAction;
use App\Http\Requests\Domain\Admin\GeneralSetting\GeneralSettingRequest;
use App\Models\Domain\Admin\GeneralSetting;

class GeneralSettingsController
{
    public function index()
    {
        return ApiReturnResponse::success(GeneralSettingResource::collection(GeneralSetting::all()));
    }

    public function store(GeneralSettingRequest $request)
    {
        return (new SetGeneralSettingAction)
            ->execute($request->input('name'), $request->input('value'))
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }
}
