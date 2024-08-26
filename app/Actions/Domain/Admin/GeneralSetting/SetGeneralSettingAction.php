<?php

namespace App\Actions\Domain\Admin\GeneralSetting;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Admin\GeneralSetting;

class SetGeneralSettingAction
{
    public function execute(string $settingName, $value): bool
    {
        try{
            GeneralSetting::whereName($settingName)->update(['value' => $value]);
            return true;
        }catch(Exception $ex){
            Log::error("Error @ SetGeneralSettingAction : {$ex->getMessage()}");
            return false;
        }
    }
}
