<?php

namespace App\Actions\Domain\Admin\AccountModeration;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class SetAccountActiveAction
{
    public function execute(Model $model): bool
    {
        try{
            $model->update(['active' => ! $model->active]);
        }catch(Exception $ex){
            Log::error("Error @ SetAccountActiveAction: " . $ex->getMessage());
            return false;
        }

        return true;
    }
}
