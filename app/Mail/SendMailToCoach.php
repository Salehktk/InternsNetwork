<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMailToCoach extends Mailable
{
    use Queueable, SerializesModels;

    public $coachEmail;
    public $admin;

    /**
     * Create a new message instance.
     */
    public function __construct($coachEmail, $admin, $messageBody)
    {
        $this->coachEmail = $coachEmail;
        $this->admin = $admin;
        
    }
    public function build()
    {
        $message = $this->view('email.sendmailtocoach')
        ->subject('You are assigned a new Coaching Request');

        // return $this->subject($this->subject)
        //             ->view('email.sendmailtocoach'); // view blade template for the email body
    }

    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Send Mail To Coach',
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
