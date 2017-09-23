<?php

namespace cms\core\user\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

//models
use cms\core\user\Models\UserModel;
class UserRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;
    /*
     * register user id
     */
    public $user_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $id = $this->user_id;
        $data = UserModel::with('group')->where('id',$id)->first();
        return $this->markdown('user::mail.user_register')->with('data',$data);
    }
}
