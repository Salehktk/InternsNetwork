<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailToClientandOther extends Mailable
{
    use Queueable, SerializesModels;

    private $clientmail;
    private $client_name;
    /**
     * Create a new message instance.
     */
    public function __construct($clientmail, $client_name)
{
    $this->clientmail = $clientmail;
    $this->client_name = $client_name;
}

    /**
     * Get the message envelope.
     */
    /***************////////////****WHEN CLIENT SUBMIT NO IN FORM****///////////// */
    public function build()
    {
        return $this->view('email.mailToClientandOther', ['coachmail' => $this->clientmail, 'client_name' => $this->client_name])
        ->subject('Feedback received from Client');
      
    }

    /**
     * Get the message content definition.
     */
   
}
