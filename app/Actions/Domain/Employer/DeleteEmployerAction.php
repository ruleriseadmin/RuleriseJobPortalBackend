<?php

namespace App\Actions\Domain\Employer;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerUser;

class DeleteEmployerAction
{
    public function execute(Employer $employer, EmployerUser $employerUser): bool
    {
        DB::beginTransaction();
        try{
            $employer->delete();
            $employerUser->delete();
            DB::commit();
        }catch(Exception $ex){
            DB::rollBack();
            Log::error("Error @ DeleteEmployerAction: " . $ex->getMessage());
            return false;
        }

        return true;
    }
}
