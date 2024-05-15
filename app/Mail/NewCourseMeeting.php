<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewCourseMeeting extends Mailable
{
    use Queueable, SerializesModels;
    public $user, $course, $googlemeet;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $course, $googlemeet)
    {
        $this->user = $user;
        $this->course = $course;
        $this->googlemeet = $googlemeet;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.newCourseMeeting')
            ->with(['user' => $this->user, 'course' => $this->course, 'googlemeet' => $this->googlemeet]);
    }
}
