<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCancelledNotification extends Notification
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $cancelledAt = $this->order->cancelled_at;
        if (is_string($cancelledAt)) {
            $formattedDate = date('F d, Y h:i A', strtotime($cancelledAt));
        } else {
            $formattedDate = $cancelledAt->format('F d, Y h:i A');
        }
        
        return (new MailMessage)
            ->subject('Order #' . $this->order->id . ' Has Been Cancelled')
            ->line('We regret to inform you that an order has been cancelled by the customer.')
            ->line('Order #: ' . $this->order->id)
            ->line('Cancellation Reason: ' . $this->order->cancellation_reason)
            ->line('Cancelled On: ' . $formattedDate)
            ->line('Thank you for your understanding.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $cancelledAt = $this->order->cancelled_at;
        if (is_string($cancelledAt)) {
            $formattedDate = date('F d, Y h:i A', strtotime($cancelledAt));
        } else {
            $formattedDate = $cancelledAt->format('F d, Y h:i A');
        }

        return [
            'order_id' => $this->order->id,
            'message' => 'Order #' . $this->order->id . ' has been cancelled by the customer.',
            'cancellation_reason' => $this->order->cancellation_reason,
            'cancelled_at' => $formattedDate,
            'user_id' => $this->order->user_id,
            'user_name' => $this->order->user->name,
            'service_url' => route('seller.order.handle', $this->order->id)
        ];
    }
} 