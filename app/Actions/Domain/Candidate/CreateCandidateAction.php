<?php

namespace App\Actions\Domain\Candidate;

use App\Models\Domain\Candidate\User;
use App\Supports\HelperSupport;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CreateCandidateAction
{
    public function execute(array $inputs): ?User
    {
        $attributes = HelperSupport::camel_to_snake($inputs);

        $userAttributes = collect($attributes)
            ->only([
                'first_name',
                'last_name',
                'email',
                'password',
                'mobile_number',
                'mobile_country_code',
                'nationality',
                'location_province',
                ])
            ->merge([
                'uuid' => str()->uuid(),
                'password' => Hash::make($attributes['password']),
                ])
            ->toArray();

        $qualificationAttributes = collect($attributes)
            ->only([
                'highest_qualification',
                'year_of_experience',
                'prefer_job_industry',
                'available_to_work',
                'skills'
            ])
            ->toArray();

        DB::beginTransaction();
        try{
            //create user
            $user = User::create($userAttributes);

            //create candidate qualification
            $user->qualification()->create($qualificationAttributes);

            DB::commit();
        }catch(Exception $ex){
            DB::rollBack();
            Log::error("Error @ CreateCandidateAction : {$ex->getMessage()}");
            return null;
        }

        return $user;
    }
}
