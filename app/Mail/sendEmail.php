<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($thisMail)
    {
        $this->mail = $thisMail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        

        if($this->mail->purpose == "Payment Received"){
        return $this->subject($this->mail->purpose)->view('mails.clientreceive')
                    ->with('maildata', $this->mail);
        }
        elseif($this->mail->purpose == "Payment Successful"){
        return $this->subject($this->mail->purpose)->view('mails.userreceive')
                    ->with('maildata', $this->mail);
        }
        elseif($this->mail->purpose == "Contact us"){
        return $this->subject($this->mail->purpose)->view('mails.contactus')
                    ->with('maildata', $this->mail);
        }
        elseif($this->mail->purpose == "Bronchure Download"){
        return $this->subject($this->mail->purpose)->view('mails.bronchure')
                    ->with('maildata', $this->mail);
        }
        elseif($this->mail->purpose == "Account is credited" || $this->mail->purpose == "Password Reset"){
        return $this->subject($this->mail->purpose)->view('mails.cardupdate')
                    ->with('maildata', $this->mail);
        }
        elseif($this->mail->purpose == "Fund remittance"){
        return $this->subject($this->mail->subject)->view('mails.epay')
                    ->with('maildata', $this->mail);
        }
        elseif($this->mail->purpose == "Cash withdrawal request"){
        return $this->subject($this->mail->purpose)->view('mails.epay')
                    ->with('maildata', $this->mail);
        }
        elseif($this->mail->purpose == "Maintenace Request"){
            if($this->mail->file != "noImage.png"){
                return $this->subject($this->mail->subject)
                    ->attach(asset("maintenancefile/".$this->mail->file))
                    ->view('mails.messages')
                    ->with('maildata', $this->mail);
            }
            else{
                return $this->subject($this->mail->purpose)
                    ->view('mails.messages')
                    ->with('maildata', $this->mail);
            }

        }
        elseif($this->mail->purpose){
        return $this->subject($this->mail->purpose)->view('mails.invoicegenerate')
                    ->with('maildata', $this->mail);
        }

    }
}
