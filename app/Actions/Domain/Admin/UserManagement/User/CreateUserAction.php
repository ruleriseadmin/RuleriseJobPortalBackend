<?php

namespace App\Actions\Domain\Admin\UserManagement\User;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\Domain\Admin\AdminUser;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Domain\Shared\NotificationWithActionButton;

class CreateUserAction
{
    public function execute(array $input): ?AdminUser
    {
        DB::beginTransaction();
        try{
            $user = AdminUser::create([
                'first_name' => $input['firstName'],
                'last_name' =>$input['lastName'],
                'email' => $input['email'],
                'uuid' => str()->uuid(),
                'password' => Hash::make($input['password']),
            ]);

            $user->assignRole($input['role']);

            if ( collect($input)->has('permissions') ) {
                $user->syncPermissions($input['permissions']);
            }
            
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
                    'Kindly change your password once you login via: ' . config('env.admin.base_url').'/settings/account',
                ],
                'actionText' => 'Login',
                'actionUrl' => config('env.admin.login_url'),
            ]));
        }catch(Exception $ex){
            Log::error('Error @ CreateUserAction: sending email' . $ex->getMessage());
        }

        return $user;
    }
}
