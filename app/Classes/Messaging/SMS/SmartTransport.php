<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 02/04/16
 * Time: 08:01
 */

namespace App\Classes\Messaging\SMS;

use Artisaninweb\SoapWrapper\Facades\SoapWrapper;

class SmartTransport implements Transport
{

    protected static $WSDL = "https://ws.smartmessaging.com.ph/soap/?wsdl";

    protected static $SERVICE = "SENDSMS";

    private $token;

    /**
     * SmartTransport constructor.
     */
    public function __construct()
    {
        $this->token = env("SMARTSUITE_TOKEN");

    }

    /**
     * Create the request
     *
     * @param Message $message
     * @return array
     */
    public function request(Message $message)
    {
        $data = array(
            array(
                'token' => $this->token,
                'msisdn' => $message->to[0],
                'message' => $message->composeMessage()
            )
        );

        return $data;
    }

    /**
     * Send the Message
     *
     * @param Message $message
     * @return Message
     */
    public function send(Message $message)
    {
        $data = $this->request($message);

        $URL = "https://ws.smartmessaging.com.ph/soap/?wsdl";

        $client = new \SoapClient($URL);

        $method = 'SENDSMS';

        $client->__call($method, $data);

        $message->sent();

        return $message;
    }

}