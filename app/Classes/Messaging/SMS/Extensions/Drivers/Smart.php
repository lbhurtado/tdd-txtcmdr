<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 19/04/16
 * Time: 19:50
 */

namespace App\Classes\Messaging\SMS\Extensions\Drivers;

use SimpleSoftwareIO\SMS\Drivers\AbstractSMS;
use SimpleSoftwareIO\SMS\Drivers\DriverInterface;
use SimpleSoftwareIO\SMS\IncomingMessage;
use SimpleSoftwareIO\SMS\OutgoingMessage;
use SoapClient;

class Smart extends AbstractSMS implements DriverInterface
{
    private $token;

    private $wsdl;

    private $service;

    /**
     * @param $token
     * @param $wsdl
     * @param $service
     */
    public function __construct($token, $wsdl, $service)
    {
        $this->token = $token;
        $this->wsdl = $wsdl;
        $this->service = $service;

        $this->client = new \SoapClient($this->wsdl);
    }

    /**
     * Sends a SMS message.
     *
     * @param \SimpleSoftwareIO\SMS\OutgoingMessage $message
     * @return OutgoingMessage $message
     */
    public function send(OutgoingMessage $message)
    {
        foreach ($message->getTo() as $to)
        {
            $parameters = array(
                array(
                    'token' => $this->token,
                    'msisdn' => $to,
                    'message' => $message->composeMessage()
                )
            );

            $this->client->__call($this->service, $parameters);
        }

        return $message;
    }

    /**
     * Creates many IncomingMessage objects and sets all of the properties.
     *
     * @param $rawMessage
     * @return mixed
     */
    protected function processReceive($rawMessage)
    {
        throw new \RuntimeException('Sms Center does not support Inbound API Calls.');
    }

    /**
     * Checks the server for messages and returns their results.
     *
     * @param array $options
     * @return array
     */
    public function checkMessages(Array $options = array())
    {
        throw new \RuntimeException('Sms Center does not support Inbound API Calls.');
    }

    /**
     * Gets a single message by it's ID.
     *
     * @param $messageId
     * @return IncomingMessage
     */
    public function getMessage($messageId)
    {
        throw new \RuntimeException('Sms Center does not support Inbound API Calls.');
    }

    /**
     * Receives an incoming message via REST call.
     *
     * @param $raw
     * @return \SimpleSoftwareIO\SMS\IncomingMessage
     */
    public function receive($raw)
    {
        throw new \RuntimeException('Sms Center does not support Inbound API Calls.');
    }
}