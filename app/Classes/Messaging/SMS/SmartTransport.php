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
                ->name(self::$SERVICE)
                ->wsdl(self::$WSDL)
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
            'token'     => $this->token,
            'msisdn'    => $message->to[0]['mobile'],
            'message'   => $message->content['body']
        ];

        $message = array_merge($this->options, [
            'to' => $message->to,
            'global_merge_vars' => array_map(function ($content, $name) {
                return compact('name', 'content');
            }, $message->content, array_keys($message->content))
        ]);

//        $json = array_merge($data, compact('message'));

//        return compact('json');

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
        SoapWrapper::service(self::$SERVICE, function ($service) use ($message) {
            $service->call(self::$SERVICE, $this->request([
                'token'         => '9f4fefe761c95853f9b6a2f4801a1ea6',
                'msisdn'        => '09189362340',
                'message'       => 'Mesage 1234'
            ]));
        });

//        $response = $this->client->post(self::$endpoint, $this->request($message));

//        $message->sent();

        return $message;
    }

}