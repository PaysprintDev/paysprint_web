<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use Carbon\Carbon as Carbon;
use Illuminate\Support\Facades\Log;

class sendEmail extends Mailable implements ShouldQueue
{
    // use Queueable, SerializesModels;
    use Queueable;

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


        try {
            if ($this->mail->purpose == "Payment Received") {
                return $this->subject($this->mail->subject)->view('mails.clientreceive')
                    ->with('maildata', $this->mail)->delay(Carbon::now()->addMinutes(5));
            } elseif ($this->mail->purpose == "Payment Successful") {
                return $this->subject($this->mail->subject)->view('mails.userreceive')
                    ->with('maildata', $this->mail)->delay(Carbon::now()->addMinutes(5));
            } elseif ($this->mail->purpose == "Contact us") {
                return $this->subject("URGENT MESSAGE for your attention!")->view('mails.contactus')
                    ->with('maildata', $this->mail)->delay(Carbon::now()->addMinutes(5));
            } elseif ($this->mail->purpose == "Bronchure Download") {
                return $this->subject($this->mail->purpose)->view('mails.bronchure')
                    ->with('maildata', $this->mail)->delay(Carbon::now()->addMinutes(5));
            } elseif ($this->mail->purpose == "Account is credited" || $this->mail->purpose == "Password Reset") {
                return $this->subject($this->mail->subject)->view('mails.cardupdate')
                    ->with('maildata', $this->mail)->delay(Carbon::now()->addMinutes(5));
            } elseif ($this->mail->purpose == "Fund remittance" || $this->mail->purpose == "Your PaySprint Referral Account Actiavted" || $this->mail->purpose == "Incomplete Setup" || $this->mail->purpose == "Refund Request") {
                return $this->subject($this->mail->subject)->view('mails.epay')
                    ->with('maildata', $this->mail)->delay(Carbon::now()->addMinutes(5));
            } elseif ($this->mail->purpose == "Business Page Setup") {
                return $this->subject($this->mail->subject)->view('mails.businesspagesetup')
                    ->with('maildata', $this->mail)->delay(Carbon::now()->addMinutes(5));
            }
            elseif ($this->mail->purpose == "Cash withdrawal request" || $this->mail->purpose == "Verify OTP" || $this->mail->purpose == "Account Verification") {
                return $this->subject($this->mail->purpose)->view('mails.epay')
                    ->with('maildata', $this->mail)->delay(Carbon::now()->addMinutes(5));
            } elseif ($this->mail->purpose == "Flagged Account") {
                return $this->subject($this->mail->subject)->view('mails.cardupdate')
                    ->with('maildata', $this->mail)->delay(Carbon::now()->addMinutes(5));
            } elseif ($this->mail->purpose == "New Login") {
                return $this->subject($this->mail->subject)->view('mails.logindetect')
                    ->with('maildata', $this->mail)->delay(Carbon::now()->addMinutes(5));
            } elseif ($this->mail->purpose == "Maintenace Request") {
                if ($this->mail->file != "noImage.png") {
                    return $this->subject($this->mail->subject)
                        ->attach(asset("maintenancefile/" . $this->mail->file))
                        ->view('mails.messages')
                        ->with('maildata', $this->mail)->delay(Carbon::now()->addMinutes(5));
                } else {
                    return $this->subject($this->mail->purpose)
                        ->view('mails.messages')
                        ->with('maildata', $this->mail)->delay(Carbon::now()->addMinutes(5));
                }
            }
            elseif ($this->mail->purpose == "Daily Transaction Report") {
                if ($this->mail->file !== null) {
                    return $this->subject($this->mail->subject)
                        ->attach(asset($this->mail->file))
                        ->view('mails.epay')
                        ->with('maildata', $this->mail)->delay(Carbon::now()->addMinutes(5));
                }
                else {
                    return $this->subject($this->mail->purpose)
                        ->view('mails.messages')
                        ->with('maildata', $this->mail)->delay(Carbon::now()->addMinutes(5));
                }
            }
            elseif ($this->mail->purpose == "Generate Invoice") {
        return $this->subject($this->mail->subject)->view('mails.invoicegenerate')
                    ->with('maildata', $this->mail)->delay(Carbon::now()->addMinutes(5));
            }
            elseif($this->mail->purpose){
                return $this->subject($this->mailData->subject)
                        ->view('mails.securitycheck')
                        ->with('mailData', $this->mailData)->delay(Carbon::now()->addMinutes(5));
            }

        } catch (\Throwable $th) {
            Log::error('Error: ' . $th->getMessage() . ' | ' . $this->mail->purpose);
        }
    }
}

