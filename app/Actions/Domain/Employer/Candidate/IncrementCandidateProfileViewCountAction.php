<?php

namespace App\Actions\Domain\Employer\Candidate;

use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Candidate\User;

class IncrementCandidateProfileViewCountAction
{
    public function execute(User $user, $viaBy = 'view_count')
    {
        try{
            $view = $user->profileViewCounts()->whereDate('created_at', Carbon::now())->first();
            $view = $view
                ? $view->update([$viaBy => $view->$viaBy + 1])
                : $user->profileViewCounts()->create([
                    $viaBy => 1,
                ]);
        }catch(Exception $ex){
            Log::error('Error @ IncrementCandidateProfileViewCountAction: ' . $ex->getMessage());
            throw new Exception("Could not increment candidate profile view count - {$ex->getMessage()}");
        }
    }
}
