<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;

class NewServiceAddedNotification extends Notification
{
    private $sellerName;
    private $serviceName;

    public function __construct($sellerName, $serviceName)
    {
        $this->sellerName = $sellerName;
        $this->serviceName = $serviceName;
    }

    public function via($notifiable)
    {
        return ['database', 'mail']; // Specify the channels here
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "New service '{$this->serviceName}' added by {$this->sellerName}."
        ];
    }

    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->line("New service '{$this->serviceName}' added by {$this->sellerName}.")
            ->action('View Service', url('/services'));
    }
}
