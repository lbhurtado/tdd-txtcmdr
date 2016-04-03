<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 01/04/16
 * Time: 12:02
 */

namespace App\Classes\Messaging\SMS;


class Sender
{
    /**
     * @var Transport
     */
    private $transport;

    /**
     * @return Transport
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * @param Transport $transport
     * @return void
     */
    public function __construct(Transport $transport)
    {
        $this->transport = $transport;
    }

    /**
     * Send a Message through the Mailer
     *
     * @param Message $message
     * @return Message
     */
    public function send(Message $message)
    {
        return $this->transport->send($message);
    }
}