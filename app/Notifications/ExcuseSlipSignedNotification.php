<?php

namespace App\Notifications;

use App\Models\ExcuseSlip;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ExcuseSlipSignedNotification extends Notification
{
    use Queueable;

    protected $excuseSlip;

    /**
     * Create a new notification instance.
     *
     * @param  ExcuseSlip  $excuseSlip
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
        return ['mail'];
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
            ->subject('Excuse Slip Signed by Teacher')
            ->greeting('Hello ' . $this->excuseSlip->student->first_name)
            ->line('Your excuse slip has been signed by your teacher.')
            ->line('Excuse Slip Details:')
            ->line('Reason: ' . $this->excuseSlip->reason)
            ->line('Submitted By: ' . $this->excuseSlip->submitted_by)
            ->line('Please check your account for further details.')
            ->line('Thank you.');
    }

    // ...
}