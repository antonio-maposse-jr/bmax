<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DispatchStageComplete extends Notification implements ShouldQueue
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
        ->subject('Order Dipatched')
        ->greeting('Dear ' . $this->orderData['customer_name'])
        ->line('Your order with the details below has been fully dispatched. Thank you for Trusting BoardmartZW to Deliver Cutting edge quality to your projects.')
        ->line('Order Number: ' . $this->orderData['order_number'])
        ->line('Invoice Value: ' . $this->orderData['invoice_value'])
        ->line('Amount paid: ' . $this->orderData['amount_paid'])
        ->line('Sales Person: ' . $this->orderData['sales_person'])
        ->line('We would love to hear your feedback regarding our service, quality and any other matters that are of value to you. Please share your feedback on the following platforms and our dedicated Service Quality Assurance Team (SQAT) will process the feedback for the continious improvement of our products and services.')
        ->line('Email: feedback@boardmart.co.zw')
        ->line('Whatsapp: +263 78 508 7805')
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
