<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Lang;

class MembershipRejected extends Notification
{
    use Queueable;

    protected $rejectionReason;

    /**
     * Create a new notification instance.
     */
    public function __construct($rejectionReason)
    {
        $this->rejectionReason = $rejectionReason;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        Log::info('Starting email notification process', [
            'recipient' => $notifiable->email,
            'name' => $notifiable->name
        ]);
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        Log::info('Preparing email content', [
            'recipient' => $notifiable->email,
            'rejection_reason' => $this->rejectionReason
        ]);
        
        return (new MailMessage)
            ->subject(Lang::get('Pendaftaran Keahlian Ditolak'))
            ->view('emails.membership-rejected', [
                'member' => $notifiable,
                'rejectionReason' => $this->rejectionReason
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'rejection_reason' => $this->rejectionReason
        ];
    }

    /**
     * Handle a failed notification
     */
    public function failed(\Exception $e)
    {
        Log::error('Email notification failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'rejection_reason' => $this->rejectionReason
        ]);
    }
}
