<?php
/**
 * Created by PhpStorm.
 * User: lbhurtado
 * Date: 02/04/16
 * Time: 19:33
 */

namespace App\Classes\Messaging\SMS;

use \Telerivet_API;
//
//define('API_KEY', env('TELERIVET_API_KEY'));
//define('PROJECT_ID', env('TELERIVET_PROJECT_ID'));
define('ELOAD_ID', env('TELERIVET_ELOAD_SERVICE_ID'));

class TelerivetTransport implements Transport
{
    protected $api;

    protected $project;

    /**
     * TelerivetTransport constructor.
     */
    public function __construct($api_key, $project_id)
    {
        $this->api = new Telerivet_API($api_key);

        $this->project = $this->api->initProjectById($project_id);
    }

    /**
     * Create the request
     *
     * @param Message $message
     * @return array
     */
    public function request(Message $message)
    {
        $content = $message->composeMessage();

        $to_numbers = array_pluck($message->to, 'mobile');

        return compact('content', 'to_numbers');
    }

    /**
     * Send the Message
     *
     * @param Message $message
     * @return Message
     */
    public function send(Message $message)
    {
        $result = $this->project->sendMessages($this->request($message));

        if ((int) $result['count_queued'] > 0) $message->sent();

        return $message;
    }

}