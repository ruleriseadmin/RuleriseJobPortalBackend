<?php

namespace App\Actions\Domain\Candidate;

use App\Models\Domain\Candidate\User;
use Exception;
use Illuminate\Support\Facades\Log;

class DeleteAccountAction
{
    public function execute(User $user): bool
    {
        try {
            $user->delete();
        } catch (Exception $ex) {
            Log::error("Error @ DeleteAccountAction : {$ex->getMessage()}");
            return false;
        }

        return true;
    }
}
