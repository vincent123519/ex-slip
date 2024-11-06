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

    public function __construct(ExcuseSlip $excuseSlip)
    {
        $this->excuseSlip = $excuseSlip;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Excuse Slip Created')
            ->greeting('Hello ' . $this->excuseSlip->counselor->first_name)
            ->line('An excuse slip has been created for one of your students.')
            ->line('Excuse Slip Details:')
            ->line('Student ID: ' . $this->excuseSlip->student_id)
            ->line('Student Name: ' . $this->excuseSlip->student->first_name . ' ' . $this->excuseSlip->student->last_name)
            ->line('Reason: ' . $this->excuseSlip->reason)
            ->action('View Excuse Slip', url('/' . $this->excuseSlip->id))
            ->line('Thank you for your attention.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'excuse_slip_id' => $this->excuseSlip->id,
            'message' => 'An excuse slip has been created for one of your students.',
        ];
    }
}