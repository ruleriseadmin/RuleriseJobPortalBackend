<?php

namespace App\Actions\Domain\Employer\Job\CandidateJobPool;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\Job\CandidateJobPool;

class CreateCandidatePoolAction
{
    public function execute(Employer $employer, array $input): ?CandidateJobPool
    {
        try{
            $input['uuid'] = str()->uuid();
            $candidatePool = $employer->candidatePools()->create($input);
        }catch(Exception $ex){
            Log::error('Error @ CreateCandidatePoolAction: ' . $ex->getMessage());
            return null;
        }

        return $candidatePool;
    }
}
