<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserInfo extends Mailable
{
    use Queueable, SerializesModels;
    protected $sender;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sender)
    {
        //
        $this->sender = $sender;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Invitación para quiniela Prensa Libre 2018')->view('myemailview')->with($this->sender);
    }
}
