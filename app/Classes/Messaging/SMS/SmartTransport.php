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

        SoapWrapper::add(function ($service) {
            $service
                ->name(self::$SERVICE)
                ->wsdl(self::$WSDL)
                ->trace(true)                                                   // Optional: (parameter: true/false)
                ->cache(WSDL_CACHE_NONE);                                       // Optional: Set the WSDL cache
        });
    }

    /**
     * Create the request
     *
     * @param Message $message
     * @return array
     */
    public function request(Message $message)
    {
        $data = [];

        foreach ($message->to as $addressee) {
            $data [] = [
                'token'     => $this->token,
                'msisdn'    => $addressee['mobile'],
                'message'   => $message->content['body']
            ];
        }

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

        SoapWrapper::service(self::$SERVICE, function ($service) use ($data) {
            foreach ($data as $d) {
                $service->call(self::$SERVICE, array($d));
            }
        });

        $message->sent();

        return $message;
    }

}