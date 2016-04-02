<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 01/04/16
 * Time: 12:07
 */

namespace App\Classes\Messaging\SMS;

use Psr\Log\LoggerInterface;

class LogTransport implements Transport
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param LoggerInterface $logger
     * @return void
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Send the Message
     *
     * @param Message $message
     * @return Message
     */
    public function send(Message $message)
    {
        $this->logger->debug('Sender:', $message->toArray());

        $message->sent();

        return $message;
    }

}