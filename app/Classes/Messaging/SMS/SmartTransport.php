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

    private $msisdn;

    /**
     * SmartTransport constructor.
     */
    public function __construct()
    {
        $this->token = env("SMARTSUITE_TOKEN");

        SoapWrapper::add(function ($service) {
            $service
                ->name('SENDSMS')
                ->wsdl('https://ws.smartmessaging.com.ph/soap/?wsdl')
                ->trace(true)                                                   // Optional: (parameter: true/false)
                ->cache(WSDL_CACHE_BOTH);                                       // Optional: Set the WSDL cache
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
        $data = [
            'token'         => '9f4fefe761c95853f9b6a2f4801a1ea6',
            'msisdn'        => '09189362340',
            'message'       => 'Third message'
//            'token'     => $this->token,
//            'msisdn'    => $message->to[0]['mobile'],
//            'message'   => $message->content['body']
        ];

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

        SoapWrapper::service('SENDSMS', function ($service) use ($data) {
            $service->call('SENDSMS', [$data]);
        });

        $message->sent();

        return $message;
    }

}