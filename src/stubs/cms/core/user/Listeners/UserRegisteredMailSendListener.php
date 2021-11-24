<?php

namespace cms\core\user\Listeners;

use cms\core\user\Events\UserRegisteredEvent;
//helpers
use Configurations;
use Illuminate\Support\Facades\Mail;
use CmsMail;
//mail
use cms\core\user\Mail\UserRegisteredMail;

//models
use cms\core\user\Models\UserModel;

class UserRegisteredMailSendListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  Test  $event
     * @return void
     */
    public function handle(UserRegisteredEvent $event)
    {
        $config = @Configurations::getParm('user', 1);
        $verification_type = $config->register_verification;

        $user = UserModel::with("group")->find($event->user_id);
        $to = '';
        switch ($verification_type) {
            case 1:
                //self verification
                $to = $user->email;
                break;
            case 2:
                //admin verification
                $siteconfig = Configurations::getConfig('site');
                $to = $siteconfig->from_mail;
                break;
            default:
                $to = $user->email;;
        }
        if ($to != '') {
            CmsMail::setMailConfig();
            Mail::to($to)->queue(new UserRegisteredMail($event->user_id));
        }
    }
}
