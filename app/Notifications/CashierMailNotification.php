<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CashierMailNotification extends Notification  implements ShouldQueue
{
    use Queueable;

    protected $orderData;
    /**
     * Create a new notification instance.
     */
    public function __construct($orderData)
    {
        $this->orderData = $orderData;
        //
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
     */public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Order Confirmation')
            ->greeting('Dear ' . $this->orderData['customer_name'])
            ->line('Thank you for trusting BoardmartZW to Deliver Cutting Edge Quality for your project.')
            ->line('We are pleased to advise you that your Order has been created and invoiced and shall be proceeding to Production under the following details:')
            ->line('Order Number: ' . $this->orderData['order_number'])
            ->line('Invoice Value: ' . $this->orderData['invoice_value'])
            ->line('Amount paid: ' . $this->orderData['amount_paid'])
            ->line('Sales Person: ' . $this->orderData['sales_person'])
            ->line('Please find attached documents for your files. Should there be any discrepancies, please contact the Sales Person.')
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
