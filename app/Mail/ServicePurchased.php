<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ServicePurchased extends Mailable
{
    use Queueable, SerializesModels;

    // public $email;
    // public $first_name;
    // public $last_name;
    // public $serviceNames;
    // public $payment_id;
 public $emailData;
    public function __construct($emailData)
    {
        $this->emailData = $emailData;
    }
   
   
  

    public function build()
    {


        
        return $this->view('email.service_purchased')->with($this->emailData)
        ->subject('Purchased Services');
       
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
