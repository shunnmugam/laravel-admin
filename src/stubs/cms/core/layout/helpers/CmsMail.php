<?php
namespace cms\core\layout\helpers;

use Config;
use Configurations;
use Cms;

use cms\core\configurations\Models\ConfigurationModel;
class CmsMail
{
    /*
     * set mail config
     */
    public static function setMailConfig($config=[])
    {
        if(count($config)==0) {
            $mailer=Configurations::getConfig('mail');
            $mail = (object) self::getMailerList($mailer->from_mailer);
            $config = array(
                'driver' => $mail->driver,
                'host' => $mail->host,
                'port' => $mail->port,
                'from' => array('address' => $mailer->from_mail, 'name' => $mailer->from_mail_name),
                'encryption' => $mail->encryption,
                'username' => $mailer->from_mail,
                'password' => base64_decode($mailer->from_mail_password),
                'sendmail' => '/usr/sbin/sendmail -bs',
                'pretend' => false
            );
        }

        Config::set('mail',$config);
    }
    /*
     * get mailer list
     */
    public static function getMailerList($mailer_name='')
    {
        $data = include(Cms::module('layout')->getCorePath().DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'mailer.php');
        if($mailer_name!='')
            $data = $data[$mailer_name];
        return $data;
    }
}