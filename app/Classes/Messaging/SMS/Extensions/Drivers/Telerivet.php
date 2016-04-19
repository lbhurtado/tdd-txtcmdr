<?php

namespace App\Classes\Messaging\SMS\Extensions\Drivers;

use SimpleSoftwareIO\SMS\Drivers\AbstractSMS;
use SimpleSoftwareIO\SMS\Drivers\DriverInterface;
use SimpleSoftwareIO\SMS\IncomingMessage;
use SimpleSoftwareIO\SMS\OutgoingMessage;
use \Telerivet_API;

class Telerivet extends AbstractSMS implements DriverInterface
{
    protected $api;

    protected $project;

    public function __construct($api_key, $project_id)
    {
        $this->api = new Telerivet_API($api_key);
        $this->project = $this->api->initProjectById($project_id);
    }

    protected function request(OutgoingMessage $message)
    {
        $content = $message->composeMessage();
        $to_numbers = $message->getTo();

        return compact('content', 'to_numbers');
    }

    public function send(OutgoingMessage $message)
    {
        $this->project->sendMessages($this->request($message));

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