<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CoachingSubmission extends Mailable
{
    use Queueable, SerializesModels;
    public $admin;
    public $identifier;
    
    /**
     * Create a new message instance.
     */
  public function __construct($admin, $identifier)
{
   
    $this->admin=$admin;
    $this->identifier=$identifier;

}


  public function build()
    {
        $resumeFileNames = json_decode($this->admin['resume']);

        $message = $this->view('email.coachingsubmission', ['admin' => $this->admin, 'identifier' =>$this->identifier ])
        ->subject('Coaching Setup: Coach and Question Batch Assigned');
        foreach ($resumeFileNames as $fileName) {
            $fileName = str_replace(['[', ']'], '', $fileName);

            $fileName = trim($fileName, '"');

            $message->attach(storage_path('app/resumes/' . $fileName));
        }

        return $message;
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    // public function attachments(): array
    // {
    //     return [];
    // }
}