<?php

namespace App\Mail;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeadReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $lead;
    public $isAdminNotification;

    public function __construct(Lead $lead, bool $isAdminNotification = false)
    {
        $this->lead = $lead;
        $this->isAdminNotification = $isAdminNotification;
    }

    public function build()
    {
        $subject = $this->isAdminNotification
            ? "[TechAnalytica Lead] New Demo/Pricing Request for {$this->lead->tool->name}"
            : "🔥 New High-Intent Lead for {$this->lead->tool->name} on TechAnalytica";

        return $this->subject($subject)
            ->view('emails.lead-received');
    }
}
