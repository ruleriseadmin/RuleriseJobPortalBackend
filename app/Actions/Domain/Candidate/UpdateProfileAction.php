<?php

namespace App\Actions\Domain\Candidate;

use App\Models\Domain\Candidate\User;
use App\Supports\HelperSupport;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class UpdateProfileAction
{
    public function execute(User $user, array $inputs, bool $isProfileSetting = true) : ?User
    {
        $inputs = Arr::except($inputs, ['email']); //don't update email

        try {
           $user->update(HelperSupport::camel_to_snake($inputs));

           //only update on profile setting and not account setting
           if ( $isProfileSetting ){
            $inputs['availableToWork'] = $inputs['availableToWork'] == 'yes';

            $user->qualification->update(HelperSupport::camel_to_snake($inputs));

            $user->portfolio->update(HelperSupport::camel_to_snake($inputs));
           }

        } catch (Exception $ex) {
            Log::error("Error @ UpdateProfileAction : {$ex->getMessage()}");
            return null;
        }

        $user->refresh();
        return $user;
    }
}
