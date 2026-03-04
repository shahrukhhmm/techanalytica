<?php

namespace App\Mail;

use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubmissionReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $submission;
    public $isAdmin;

    public function __construct(Submission $submission, $isAdmin = false)
    {
        $this->submission = $submission;
        $this->isAdmin = $isAdmin;
    }

    public function build()
    {
        $subject = $this->isAdmin ? 'New Product Submission Request' : 'Your Product Submission Received';
        return $this->subject($subject)
                    ->view('emails.submission-received');
    }
}
