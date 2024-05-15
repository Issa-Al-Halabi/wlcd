<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $code;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($code, $user)
    {
        $this->user = $user;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.forget')
        ->with([
            'user' => $this->user,
            'code' => $this->code
        ]);
    }
}
