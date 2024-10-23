<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\URL;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class CoachToClient extends Mailable
{
    use Queueable, SerializesModels;


      public $savecoachfeedback;
    public $identifier;
    public $client_name;
    
    /**
     * Create a new message instance.
     */
    public function __construct($savecoachfeedback, $identifier, $client_name)
    {
        $this->savecoachfeedback = $savecoachfeedback;
        $this->identifier = $identifier;
        $this->client_name = $client_name;
        
    }


    public function build()
    {
        $identifier = $this->identifier; 
        $client_name = $this->client_name; 
        $url = URL::signedRoute('clientFeedback', ['identifier' => $identifier, 'client_name' => $client_name]); 
    
        return $this->view('email.coachtoclient', compact('url')) 
            ->subject('Get your feedback');
    }


    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Coach To Client',
    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    // /**
    //  * Get the attachments for the message.
    //  *
    //  * @return array<int, \Illuminate\Mail\Mailables\Attachment>
    //  */
    // public function attachments(): array
    // {
    //     return [];
    // }
}
