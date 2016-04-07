<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 05/04/16
 * Time: 22:23
 */

namespace App\Listeners;

use App\Events\MissiveWasPosted;
use App\Classes\Repositories\Interfaces\UserRepositoryInterface;
use App\Classes\Messaging\SMS\Facades\SMS;
use App\Classes\Messaging\SMS\Message;

class Reflector extends Listener
{
    public function whenMissiveWasPosted(MissiveWasPosted $event)
    {
        $user = \App::make(UserRepositoryInterface::class)->find($event->missive->mobile);

        if ( !is_null($user) )
        {
            $template = 'sms.testing.transport';
            $content = [
                'header' => "fr: {$user->handle}",
                'body' => "{$event->missive->body}",
                'footer' => ""
            ];

            $message = (new Message($template, $content))
                ->to('User', '09173011987');

            SMS::send($message);
        }
    }
}