<?php

namespace App\Notifications;

use App\Models\ExcuseSlip;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ExcuseSlipApprovedNotification extends Notification implements ShouldQueue
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
            ->subject('Excuse Slip Approval Notification')
            ->greeting('Hello ' .  $this->excuseSlip->dean->first_name)
            ->line('An excuse slip is pending for your approval.')
            ->line('Excuse Slip Details:')
            ->line('Student Name: ' . $this->excuseSlip->student->first_name . ' ' . $this->excuseSlip->student->last_name)
            ->line('Reason: ' . $this->excuseSlip->reason)
            ->line('Submitted By: ' . $this->excuseSlip->counselor->first_name)
            ->line('Please review and take appropriate action.')
            ->line('Thank you.');
    }
}