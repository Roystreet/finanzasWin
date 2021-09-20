<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailable extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
     protected $name;
    public function __construct($name)
    {
        //
        $this->name= $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      $this->subject("RESPALDO DB ACCIONISTAS-".date("Y").date("m").date("d").date("H").date("i").date("s"));
      return $this->view('respaldo')->attach('storage/logs/'.$this->name.'.backup');

    }
}
