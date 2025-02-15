<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Loan;

class LoanRejected extends Notification 
{
    use Queueable;

    protected $loan;
    protected $rejectionReason;

    public function __construct(Loan $loan, $rejectionReason)
    {
        $this->loan = $loan;
        $this->rejectionReason = $rejectionReason;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Permohonan Pinjaman Ditolak')
            ->markdown('emails.loans.rejected', [
                'loan' => $this->loan,
                'rejectionReason' => $this->rejectionReason
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'loan_id' => $this->loan->loan_id,
            'message' => 'Permohonan pinjaman anda telah ditolak.',
            'rejection_reason' => $this->rejectionReason
        ];
    }
} 