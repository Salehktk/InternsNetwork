<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class MailToClientAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $clientName;
    public $identifier;
    public $admin;


    /**
     * Create a new message instance.
     */
    public function __construct($clientName,  $admin,  $messageBody,)
    {
        $this->clientName = $clientName;

        $this->admin = $admin;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {

        $resumeFileNames = json_decode($this->admin['resume']);

        $message = $this->view('email.mailtoclientadmin', [
            'admin' => $this->admin,
            'clientName' => $this->clientName,
        ])
            ->subject('You are assigned a Coaching Session');
        foreach ($resumeFileNames as $fileName) {
            $fileName = str_replace(['[', ']'], '', $fileName);

            $fileName = trim($fileName, '"');

            $message->attach(storage_path('app/resumes/' . $fileName));
        }

        return $message;
    }
}
