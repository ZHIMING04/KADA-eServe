<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Loan;

class MailLoanReject extends Mailable
{
    use Queueable, SerializesModels;

    public $loan;
    public $rejection_reason;

    public function __construct(Loan $loan, $rejection_reason)
    {
        $this->loan = $loan;
        $this->rejection_reason = $rejection_reason;
    }

    public function build()
    {
        return $this->view('emails.loan_reject')
                    ->with([
                        'loan' => $this->loan,
                        'rejection_reason' => $this->rejection_reason,
                    ]);
    }
}