<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 31/03/16
 * Time: 07:42
 */

namespace App\Classes\Messaging\Mailers;

use Illuminate\Mail\Mailer as Mail;

abstract class Mailer
{
    /**
     * @var
     */
    private $mail;

    /**
     * Mailer constructor.
     * @param $mail
     */
    public function __construct(Mail $mail)
    {
        $this->mail = $mail;
    }


    /**
     * @param $user
     * @param $subject
     * @param $view
     * @param $data
     */
    public function sendTo($user, $subject, $view, $data = [])
    {
        $this->mail->queue($view, $data, function($message) use ($user, $subject) {
            $message->to($user->email)->subject($subject);
        });
    }
}