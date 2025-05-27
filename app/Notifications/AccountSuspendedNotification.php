<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountSuspendedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The suspension reason.
     *
     * @var string
     */
    protected $reason;

    /**
     * Create a new notification instance.
     *
     * @param string $reason
     */
    public function __construct(string $reason)
    {
        $this->reason = $reason;
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
                    ->subject('Your Account Has Been Suspended')
                    ->greeting('Hello ' . $notifiable->name)
                    ->line('We regret to inform you that your account has been suspended.')
                    ->line('Reason for suspension: ' . $this->reason)
                    ->line('If you believe this is an error or would like to appeal this decision, please contact our support team.')
                    ->line('Thank you for your understanding.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Account Suspended',
            'message' => 'Your account has been suspended. Reason: ' . $this->reason,
            'type' => 'account_suspended',
        ];
    }
}
