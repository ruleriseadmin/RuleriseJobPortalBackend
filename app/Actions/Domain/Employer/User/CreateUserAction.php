<?php

namespace App\Actions\Domain\Employer\User;

use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\Domain\Employer\EmployerUser;
use Illuminate\Support\Facades\Notification;
use App\Actions\Domain\Employer\AttachUserToEmployerAction;
use App\Models\Domain\Employer\Employer;
use App\Notifications\Domain\Shared\NotificationWithActionButton;

class CreateUserAction
{
    public function execute(Employer $employer, array $input): ?EmployerUser
    {
        DB::beginTransaction();
        try{
            $user = EmployerUser::create([
                'email' => preg_replace('/\s+/', '', strtolower($input['email'])),
                'uuid' => str()->uuid(),
                'password' => Hash::make($input['password']),
            ]);

            //create new employer access
            (new AttachUserToEmployerAction)->execute($employer, $user, $input, '');

            DB::commit();
        }catch(Exception $ex){
            DB::rollBack();
            Log::error('Error @ CreateUserAction: ' . $ex->getMessage());
            return null;
        }

        try{
            Notification::route('mail', $user->email)->notify(new NotificationWithActionButton([
                'subject' => 'Account creation invite',
                'greeting' => $user->full_name,
                'messages' => [
                    'You have been invited to access the admin portal. Please click the button below to login.',
                    'If you did not request this invitation, please ignore this email.',
                    "Password: {$input['password']}",
                    'Kindly change your password once you login via: ' . config('env.employer.base_url').'/settings/account',
                ],
                'actionText' => 'Login',
                'actionUrl' => config('env.employer.login_url'),
            ]));
        }catch(Exception $ex){
            Log::error('Error @ CreateUserAction: sending email' . $ex->getMessage());
        }

        return $user;
    }
}
