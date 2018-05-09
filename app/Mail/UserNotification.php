<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserNotification extends Mailable
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
        return $this->subject('Quiniela PrensaLibre 2018')->view('usernotification')->with($this->sender);
    }
}
