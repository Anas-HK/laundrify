<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountUnsuspendedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Your Account Has Been Reactivated')
                    ->greeting('Hello ' . $notifiable->name)
                    ->line('Good news! Your account has been reactivated.')
                    ->line('You can now log in and continue using our services.')
                    ->action('Log In Now', url('/login'))
                    ->line('Thank you for your patience and for being a valued member of our community.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Account Reactivated',
            'message' => 'Your account has been reactivated. You can now log in and continue using our services.',
            'type' => 'account_unsuspended',
        ];
    }
}
