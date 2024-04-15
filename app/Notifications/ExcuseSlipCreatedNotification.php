<?php

namespace App\Notifications;

use App\Models\ExcuseSlip;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ExcuseSlipCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $excuseSlip;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\ExcuseSlip  $excuseSlip
     * @return void
     */
    public function __construct(ExcuseSlip $excuseSlip)
    {
        $this->excuseSlip = $excuseSlip;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail']; // You can add additional channels here, such as 'database' or 'slack'
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Excuse Slip Created')
            ->greeting('Hello ' . $notifiable->name)
            ->line('An excuse slip has been created for one of your students.')
            ->line('Excuse Slip Details:')
            ->line('Student ID: ' . $this->excuseSlip->student_id)
            ->line('Reason: ' . $this->excuseSlip->reason)
            ->action('View Excuse Slip', url('/' . $this->excuseSlip->id))
            ->line('Thank you for your attention.');
    }
}