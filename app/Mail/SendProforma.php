<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Proforma;

class SendProforma extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $proforma;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, Proforma $proforma)
    {
        $this->user = $user;
        $this->proforma = $proforma;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.proforma')->subject("Su Proforma esta lista");
    }
}

