<?php

namespace App\Actions\Domain\Admin\AccountModeration;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class SetShadowBanAction
{
    public function execute(Model $model, string $type): bool
    {
        if ( $model->hasBan($type) ){
            $model->removeBan($type);
            return true;
        };

        try{
            $model->setBan($type);
        }catch (Exception $exception){
            Log::error("Error @ SetShadowBanAction: " . $exception->getMessage());
            return false;
        }

        return true;
    }
}
