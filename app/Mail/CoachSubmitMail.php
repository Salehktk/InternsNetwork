<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CoachSubmitMail extends Mailable
{
    use Queueable, SerializesModels;

    public $savecoachfeedback;
    public $identifier;
    
    /**
     * Create a new message instance.
     */
    public function __construct($savecoachfeedback, $identifier)
    {
        $this->savecoachfeedback = $savecoachfeedback;
        $this->identifier = $identifier;

        
    }


    public function build()
    {
        return $this->view('email.coachsubmitmail', ['identifier' => $this->identifier]) 
        ->subject('Coach Feedback for the Coaching Request is received');


    }

    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Coach Submit Mail',
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

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
