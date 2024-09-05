<?php

namespace App\Actions\Domain\Employer\Job;

use App\Models\Domain\Employer\EmployerJob;
use Exception;
use Illuminate\Support\Facades\Log;

class PublishJobAction
{
    public function execute(EmployerJob $employerJob): bool
    {
        try{
            $employerJob->update([
                'active' => true,
                'is_draft' => false,
            ]);
            return true;
        }catch(Exception $ex){
            Log::error('Error @ PublishJobAction: ' . $ex->getMessage());
            return false;
        }
    }
}
