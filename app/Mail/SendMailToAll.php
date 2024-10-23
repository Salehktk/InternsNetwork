<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMailToAll extends Mailable
{
    use Queueable, SerializesModels;
    private $coachmail;
    private $clientmail;


    /**
     * Create a new message instance.
     */
    public function __construct($coachmail, $clientmail)  
    {
        $this->coachmail = $coachmail;
        $this->clientmail = $clientmail;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        return $this->view('email.sendMailToAll', ['coachmail' => $this->coachmail, 'clientmail' => $this->clientmail])
            ->subject('Feedback received from Client');
    }

    /**
     * Get the message content definition.
     */
    
}
