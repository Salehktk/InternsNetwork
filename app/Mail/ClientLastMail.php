<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClientLastMail extends Mailable
{
    use Queueable, SerializesModels;
    private $coachmail;
    private $identifier;
    private $client_name;



    /**
     * Create a client_name message instance.
     */
    public function __construct($coachmail, $identifier, $client_name)  
    {
        $this->coachmail = $coachmail;
        $this->identifier = $identifier;
        $this->client_name = $client_name;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        


        return $this->view('email.clientlastmail', ['coachmail' => $this->coachmail, 'identifier' => $this->identifier, 'clientname' => $this->client_name])
            ->subject('Here\'s the feedback from your Coach');
    }
    /**
     * Get the message envelope.
     */
   
}
