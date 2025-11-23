<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $application;

    /**
     * Create a new message instance.
     */
    public function __construct($application)
    {
        $this->application = $application;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Status Lamaran Anda')
                    ->view('emails.application_status')
                    ->with([
                        'status' => $this->application->status,
                        'job' => $this->application->job,
                        'user' => $this->application->user,
                    ]);
    }
}
