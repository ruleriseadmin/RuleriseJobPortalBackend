<?php

namespace App\Actions\Domain\Employer;

use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerUser;
use App\Supports\HelperSupport;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProcessNewEmployerAction
{
    public function execute(array $inputs) : ? EmployerUser
    {
        $attributes = HelperSupport::camel_to_snake($inputs);

        DB::beginTransaction();
        try {
            //create new employer
            $employerAttributes = collect($attributes)->only(['company_name'])->merge(['uuid' => str()->uuid()])->toArray();

            $employer = Employer::create($employerAttributes);

            //create new employer user
            $employerUser = EmployerUser::create([
                'uuid' => str()->uuid(),
                'email' => $inputs['email'],
                'password' => Hash::make($inputs['password']),
            ]);

            //create new employer access
            (new AttachUserToEmployerAction)->execute($employer, $employerUser, $inputs);

            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
            Log::error("Error in ProcessNewEmployerAction: " . $e->getMessage());
            return null;
        }

        return $employerUser;
    }
}
