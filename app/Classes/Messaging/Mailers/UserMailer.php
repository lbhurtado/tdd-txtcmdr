<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 31/03/16
 * Time: 07:53
 */

namespace App\Classes\Messaging\Mailers;


use App\Classes\User;

class UserMailer extends Mailer
{

    /**
     * instead of User use Mailable in the future
     *
     * @param User $user
     */
    public function sendWelcomeMessageTo(User $user)
    {
        $subject = "Welcome to Applester";
        $view = "emails.registration.confirm";

        $this->sendTo($user, $subject, $view);
    }
}