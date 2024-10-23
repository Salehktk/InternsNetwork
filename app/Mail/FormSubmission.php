<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\CochingSetup;

class FormSubmission extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $identifier;

    
    /**
     * Create a new message instance.
     */
  public function __construct($data, $identifier)
{
    $this->data = $data;
    $this->identifier = $identifier;

}


   public function build()
{
    return $this->view('email.formSubmission', ['identifier' => $this->identifier])
        ->subject('New Coaching Setup Request');
}


}

