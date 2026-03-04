<?php

namespace App\Mail;

use App\Models\Claim;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClaimSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $claim;
    public $isAdmin;

    public function __construct(Claim $claim, $isAdmin = false)
    {
        $this->claim = $claim;
        $this->isAdmin = $isAdmin;
    }

    public function build()
    {
        $subject = $this->isAdmin ? 'New Product Claim Request' : 'Your Product Claim Submission';
        return $this->subject($subject)
                    ->view('emails.claim-submitted');
    }
}
