<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResignationRejectedNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Permohonan Berhenti Tidak Diluluskan')
            ->view('emails.resign-status', [
                'status' => 'rejected',
                'member' => $notifiable // Assuming $notifiable is the member
            ]);
    }
} 