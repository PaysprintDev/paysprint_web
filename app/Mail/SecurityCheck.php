<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SecurityCheck extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $user)
    {
        $this->mailData = $data;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->mailData->subject)
                    ->view('mails.securitycheck')
                    ->with(['mailData' => $this->mailData, 'user' => $this->user]);
    }
}
