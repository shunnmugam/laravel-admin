<?php

namespace cms\core\newsletter\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewsLetterMail extends Mailable  implements ShouldQueue
{
    use Queueable, SerializesModels;
    /*
     * token
     */
    protected $content;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('newsletter::mail.newsletter')
            ->with('mail',$this->to)
            ->with('data',$this->content);
    }
}
