<?php

namespace cms\core\newsletter\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use Configurations;

class SubscriptionConfirmMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('newsletter::mail.subscription')
        ->subject('You’re subscribed for '.isset(Configurations::getConfig('site')->site_name)
            ? Configurations::getConfig('site')->site_name : ''.' Newsletter!')
            ->with(['mail'=>$this->to]);
    }
}
