<?php

namespace App\Actions\Domain\Employer\Job\CandidateJobPool;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Candidate\User;
use App\Models\Domain\Employer\Job\CandidateJobPool;

class AttachCandidatePoolAction
{
    public function execute(array $input): bool
    {
        try{
            foreach($input['candidatePoolIds'] as $candidateUuid){
                $candidateJobPool = CandidateJobPool::where('uuid', $candidateUuid)->first();
                if ( ! $candidateJobPool ) continue;
                $candidateJobPool->update([
                    'candidate_ids' => collect($candidateJobPool->candidate_ids ?? [])->merge($this->getCandidateIds($input['candidateIds']))
                        ->unique()->values(),
                ]);
            }
        }catch(Exception $ex){
            Log::error('Error @ AttachCandidatePoolAction: ' . $ex->getMessage());
            return false;
        }

        return true;
    }

    private function getCandidateIds(array $candidateUuids): array
    {
        return collect($candidateUuids)
            ->map(fn($uuid) => User::whereUuid($uuid)->id)->toArray();
    }
}
