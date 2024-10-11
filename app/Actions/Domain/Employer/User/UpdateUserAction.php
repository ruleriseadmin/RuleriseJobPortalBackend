<?php

namespace App\Actions\Domain\Employer\User;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerUser;

class UpdateUserAction
{
    public function execute(Employer $employer, EmployerUser $user, array $inputs)
    {

        DB::beginTransaction();
        try{
            $user->update([
                //'email' => $inputs['email'],
                'password' => $inputs['password'] ? Hash::make($inputs['password']) : $user->password,
            ]);

            $user->getCurrentEmployerAccess($employer->id)->update([
                'first_name' => $inputs['firstName'],
                'last_name' => $inputs['lastName'],
                'position_title' => $inputs['positionTitle'],
            ]);

            //->assignRole($role);

            DB::commit();

            return true;
        }catch(Exception $ex){
            DB::rollBack();
            Log::error("Error @ UpdateUserAction : " . $ex->getMessage());
            return false;
        }
    }
}
