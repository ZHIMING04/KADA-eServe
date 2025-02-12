<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class VerifyNewEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $member;
    public $newEmail;

    public function __construct($member, $newEmail)
    {
        $this->member = $member;
        $this->newEmail = $newEmail;
    }

    public function build()
    {
        $verificationUrl = URL::temporarySignedRoute(
            'change.verification.verify',
            Carbon::now()->addMinutes(60),
            ['id' => $this->member->id, 'hash' => sha1($this->newEmail)]
        );

        return $this->view('emails.verify-new-email')
                    ->subject('Sahkan Alamat Emel Baru Anda')
                    ->with([
                        'user' => $this->member,
                        'newEmail' => $this->newEmail,
                        'verificationUrl' => $verificationUrl,
                    ]);
    }
}