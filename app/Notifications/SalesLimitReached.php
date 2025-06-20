<?php

namespace App\Notifications;

use App\Models\Sale;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SalesLimitReached extends Notification implements ShouldQueue
{
    use Queueable;

    protected $sale;

    public function __construct(Sale $sale)
    {
        $this->sale = $sale;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Sales Daily Limit Reached')
            ->greeting('Hello Admin!')
            ->line("Sales representative **{$this->sale->name}** has reached their daily chat limit of 5 chats.")
            ->line("This sales person is now temporarily unavailable for new chats until tomorrow.")
            ->action('View Sales Dashboard', url('/admin/sales'))
            ->line('You can manually reset the chat count or deactivate the sales if needed.')
            ->salutation('Best regards, HiStore System');
    }

    public function toArray($notifiable)
    {
        return [
            'sale_id' => $this->sale->id,
            'sale_name' => $this->sale->name,
            'message' => "Sales {$this->sale->name} has reached daily chat limit",
            'type' => 'sales_limit_reached',
        ];
    }
} 