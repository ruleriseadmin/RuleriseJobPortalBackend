<?php

namespace App\Actions\Domain\Candidate;

use App\Models\Domain\Candidate\User;
use App\Supports\HelperSupport;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class UpdateProfileAction
{
    public function execute(User $user, array $inputs) : ?User
    {
        $inputs = Arr::except($inputs, ['email']); //don't update email

        try {
           $user->update(HelperSupport::camel_to_snake($inputs));
           $user->qualification->update(HelperSupport::camel_to_snake($inputs));
           $user->portfolio->update(HelperSupport::camel_to_snake($inputs));
        } catch (Exception $ex) {
            Log::error("Error @ UpdateProfileAction : {$ex->getMessage()}");
            return null;
        }

        $user->refresh();
        return $user;
    }
}
