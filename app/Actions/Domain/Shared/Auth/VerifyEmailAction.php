<?php

namespace App\Actions\Domain\Shared\Auth;

use App\Notifications\Domain\Shared\NotificationWithActionButton;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Candidate\User;
use Illuminate\Support\Facades\Crypt;
use App\Models\Domain\Employer\EmployerUser;
use Illuminate\Support\Facades\Notification;

class VerifyEmailAction
{
    public function execute(string $domain, string $token): bool
    {
        $decodeToken = Crypt::decrypt($token);

        $decodeToken = (object) json_decode($decodeToken);

        if ( Carbon::now()->greaterThan($decodeToken->expired_at) ) return false;

        $email = $decodeToken->email;

        $user = $domain == 'candidate' ? User::whereEmail($email) : EmployerUser::whereEmail($email);

        if ( ! $user ) return false;

        if ( $user->email_verified_at ) return false;

        $user->update([
            'email_verified_at' => Carbon::now(),
            'email_verified_token' => null,
        ]);

        $this->sendNotification($domain, $user);

        return true;
    }

    private function sendNotification(string $domain, $user)
    {
        try{
            Notification::route('mail', $user->email)->notify(new NotificationWithActionButton([
                'subject' => 'Email Verified',
                'greeting' => "Hello {$user->full_name}!",
                'messages' => [
                    'Your email has been verified.',
                    'Click the button below to view your profile.',
                ],
                'actionText' => 'View Profile',
                'actionUrl' => $domain == 'candidate' ? config('env.candidate.profile_url') : config('env.employer.profile_url'),
            ]));
        }catch(Exception $ex){
            Log::error("Error @ VerifyEmailAction::sendNotification : {$ex->getMessage()}");
        }
    }
}
