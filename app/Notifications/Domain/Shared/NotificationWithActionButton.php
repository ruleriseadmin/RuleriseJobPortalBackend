<?php

namespace App\Notifications\Domain\Shared;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificationWithActionButton extends Notification
{
    use Queueable;

    public array $mailData;


    public function __construct(array $mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->view('emails.notification-with-button')
                    ->subject(config('app.name').': '.$this->mailData['subject']??'Notification')
                    ->greeting('Hello '.$this->mailData['name']??'')
                    ->lines($this->mailData['messages']??'')
                    ->action($this->mailData['actionText']??'Click Here', $this->mailData['actionUrl']??'');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
