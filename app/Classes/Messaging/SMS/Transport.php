<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 01/04/16
 * Time: 11:59
 */

namespace App\Classes\Messaging\SMS;


interface Transport
{
    /**
     * Send the Message
     *
     * @param Message $message
     * @return Message
     */
    public function send(Message $message);
}