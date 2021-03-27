<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $msg;
    public $attachment;
    public function __construct($msg,$attachment=null)
    {
        $this->msg = $msg;
        $this->attachment = $attachment;
    }

    /**
     * Build the msg.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->attachment !=null) {
            return $this->markdown('emails.user')
            ->with(['msg' => $this->msg,])
            ->attach($this->attachment);
        }else{
            return $this->markdown('emails.user')
                ->with(['msg' => $this->msg,]);
        }
    }
}
