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
                'msisdn' => '09189362340',
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
        $to_numbers = array_pluck($message->to, 'mobile');

        $URL = "https://ws.smartmessaging.com.ph/soap/?wsdl";
        $client = new \SoapClient($URL);
        $token = "9f4fefe761c95853f9b6a2f4801a1ea6";

        $method = 'SENDSMS';

        foreach ($to_numbers as $to)
        {
            $parameters = array(
                array(
                    'token' => $token,
                    'msisdn' => $to,
                    'message' => $message->composeMessage()
                )
            );

            $client->__call($method, $parameters);
        }


        return $message;
    }

}