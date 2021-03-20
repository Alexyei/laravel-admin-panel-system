<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class VerifyCabinetEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $changes;
    public $link;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($changes, $email)
    {
        $this->changes = $changes;
        $this->link = URL::temporarySignedRoute(
            'cabinet.save', now()->addHours(1), ['verifycabinet' => $changes->id,'email'=>$email]
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.cabinet');
    }
}
