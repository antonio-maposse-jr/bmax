<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductionStageComplete extends Notification implements ShouldQueue
{
    use Queueable;

    protected $orderData;
    /**
     * Create a new notification instance.
     */
    public function __construct($orderData)
    {
        $this->orderData = $orderData;
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
        return (new MailMessage)
        ->subject('Production stage is complete')
        ->greeting('Dear ' . $this->orderData['customer_name'])
        ->line('We are pleased to advise you that your Order has been fully processed and is ready for collection.  To prepare for dispatch, please contact our Sales Team to check if there are any unpaid balances on the Order.')
        ->line('Order Number: ' . $this->orderData['order_number'])
        ->line('Invoice Value: $' . $this->orderData['invoice_value'])
        ->line('Amount paid: $' . $this->orderData['amount_paid'])
        ->line('Sales Person: ' . $this->orderData['sales_person'])
        ->line('Thank you for doing business with us and we sure hope to serve you again soon.')
        ->salutation('Kind Regards, BoardmartZW');
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
