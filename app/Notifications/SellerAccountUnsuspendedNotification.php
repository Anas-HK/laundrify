<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SellerAccountUnsuspendedNotification extends Notification implements ShouldQueue
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
                    ->subject('Your Seller Account Has Been Reactivated')
                    ->greeting('Hello ' . $notifiable->name)
                    ->line('Good news! Your seller account has been reactivated and is now fully functional.')
                    ->line('You can now login and continue providing your services to customers.')
                    ->action('Access Seller Portal', url('/login/seller'))
                    ->line('Thank you for your patience and understanding.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Seller Account Reactivated',
            'message' => 'Your seller account has been reactivated and is now fully functional.',
            'type' => 'seller_account_unsuspended',
        ];
    }
}
